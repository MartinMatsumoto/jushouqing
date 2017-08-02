/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.define('MyDesktop.AboutUsWindow', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
        'Ext.data.ArrayStore',
        'Ext.util.Format',
        'Ext.grid.Panel',
        'Ext.grid.RowNumberer'
    ],

    id: 'aboutUs-win',
    indexContentId : 1,

    init: function () {
        this.launcher = {
            text: '关于我们管理'
        };
    },

    createWindow: function () {
        var this_ = this;
        var desktop = this_.app.getDesktop();
        var win = desktop.getWindow('aboutUs-win');
        if (!win) {
            win = desktop.createWindow({
                id : 'aboutUsModifyWindow',
                layout: 'fit',
                title: '修改关于我们信息',
                closeAction: 'hide',
                width: 650,
                height: 400,
                border: false,
                modal: true,
                items: [{
                    id: 'aboutUsModifyForm',
                    xtype: 'form',
                    bodyPadding: 5,
                    frame: true,
                    url: '/structure/index_content/controller/manager_aboutus_modify.php',
                    layout: 'anchor',
                    defaultType: 'textfield',
                    fieldDefaults: {
                        labelAlign: 'left',
                        labelWidth: 80,
                        anchor: '80%'
                    },
                    items: [{
                        xtype: 'hidden',
                        name: 'id'
                    }, {
                        xtype: 'hidden',
                        name: 'image_url'
                    }, {
                        fieldLabel : '选择图片',
                        name : 'image_url_reload',
                        xtype : 'filefield',
                        vtype:'imageUpload',
                        allowBlank : true
                    }, {
                        fieldLabel: '文字内容',
                        name: 'content',
                        xtype : 'textarea',
                        allowBlank: false
                    }, {
                        fieldLabel: '跳转链接',
                        name: 'href_url',
                        allowBlank: false
                    }, {
                        fieldLabel: '温馨提示',
                        xtype : 'displayfield',
                        value : '图片推荐大小为500x310像素。'
                    }],
                    buttons: [
                        {
                            text: '重置',
                            handler: function () {
                                Ext.getCmp('aboutUsModifyForm').getForm().reset();
                            }
                        },
                        {
                            text: '提交',
                            formBind: true,
                            disabled: false,
                            handler: function () {
                                var form = Ext.getCmp('aboutUsModifyForm').getForm();
                                console.log(form.url);
                                if (form.isValid()) {
                                    form.submit({
                                        success: function () {
                                            Ext.Msg.alert('成功', '修改成功。');
                                            Ext.getCmp('aboutUsModifyWindow').close();
                                        },
                                        failure: function () {
                                            Ext.Msg.alert('失败', '请刷新后重试。');
                                        }
                                    });
                                }
                            }
                        }]
                }],
                listeners :
                {
                    show :
                    {
                        fn : function()
                        {
                            Ext.Ajax.request({
                                url: '/structure/index_content/controller/get_index_content.php',
                                params: {
                                    id: this_.indexContentId
                                },
                                method: 'POST',
                                success: function (response, options) {
                                    var json = Ext.decode(response.responseText);
                                    if(json.content){
                                        var contents = json.content;
                                        var content = {
                                            data : contents,
                                            getData : function(){
                                                return this.data;
                                            }
                                        }
                                        Ext.getCmp('aboutUsModifyForm').form.loadRecord(content);
                                    }
                                },
                                failure: function (response, options) {
                                    Ext.MessageBox.alert('失败', '请求超时或网络故障,错误编号：'+ response.status);
                                }
                            });
                        }
                    }
                }
            });
        }
        return win;
    }
});
