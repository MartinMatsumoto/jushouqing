/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
var companyActiveStore = Ext.create('Ext.data.Store', {
    fields: ['id', 'image_url', 'content', 'href_url'],
    autoLoad: false,
    proxy: {
        extraParams: {},
        type: 'rest',
        url: '/structure/index_content/controller/list_company_active.php',
        reader: {
            type: 'json',
            root: 'content'// JSON数组对象名
        },
        actionMethods: {
            read: 'POST'
        }
    }
});

//设置图片路径
function getpicPathCompanyActiveModify()
{
    var PICTURE_URL = Ext.getCmp("company_active_image_url_modify").getValue();
    if (!Ext.isEmpty(PICTURE_URL))
    {
        Ext.getCmp("companyActiveImagePathShow").src=PICTURE_URL;
    }else
    {
        Ext.getCmp("companyActiveImagePathShow").getEl().dom.src = "";
    }
}

var companyActiveSelModel = null;
function getCompanyActiveSelModel(){
    companyActiveSelModel = Ext.create('Ext.selection.CheckboxModel', {
        mode: 'SINGLE',
        listeners: {
            beforeselect: function (catgegory, record, index, obj) {
            },
            selectionchange: function (sm, selections) {
            },
            select: function (companyActive, record, index, obj) {
                currentSel = record;
                Ext.getCmp("company_active_modify_button").setDisabled(false);
            }
        }
    });
    return companyActiveSelModel;
}

Ext.define('MyDesktop.CompanyActiveWindow', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
        'Ext.data.ArrayStore',
        'Ext.util.Format',
        'Ext.grid.Panel',
        'Ext.grid.RowNumberer'
    ],

    id: 'companyActive-win',

    init: function () {
        this.launcher = {
            text: '公司动态管理'
        };
    },

    store: companyActiveStore,

    createWindow: function () {
        var this_ = this;
        var desktop = this_.app.getDesktop();
        var win = desktop.getWindow('companyActive-win');
        if (!win) {
            win = desktop.createWindow({
                id: 'companyActive-win',
                title: '公司动态管理',
                width: 740,
                height: 480,
                iconCls: 'icon-grid',
                animCollapse: false,
                constrainHeader: true,
                layout: 'fit',
                items: [
                    {
                        border: false,
                        xtype: 'grid',
                        store: this.store,
                        selModel: getCompanyActiveSelModel(),
                        columns: [
                            {
                                text: "id",
                                width: 30,
                                sortable: true,
                                dataIndex: 'id'
                            },
                            {
                                text: "文字显示",
                                width: 140,
                                sortable: true,
                                dataIndex: 'content'
                            },
                            {
                                text: "图片地址",
                                width: 250,
                                sortable: true,
                                dataIndex: 'image_url'
                            },
                            {
                                text: "跳转链接",
                                width: 250,
                                sortable: true,
                                dataIndex: 'href_url'
                            }
                        ]
                    }
                ],
                tbar: [{
                    id: 'company_active_modify_button',
                    text: '修改信息',
                    disabled: true,
                    tooltip: '修改某个公司动态填报的信息',
                    handler: function () {
                        Ext.getCmp('companyActiveModifyForm').form.loadRecord(currentSel);
                        getpicPathCompanyActiveModify();
                        this_.companyActiveModifyForm.show();
                    }
                }]
            });
            this.store.load();
        }
        return win;
    },
    currentSel: null,
    companyActiveModifyForm: Ext.create('Ext.window.Window', {
        id : 'companyActiveModifyWindow',
        layout: 'fit',
        title: '修改公司动态信息',
        closeAction: 'hide',
        width: 650,
        height: 400,
        border: false,
        modal: true,
        items: [{
            id: 'companyActiveModifyForm',
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
                name : 'image_url',
                id : 'company_active_image_url_modify',
                xtype : 'hidden'
            }, {
                xtype : 'image',
                fieldLabel : '原始图片',
                width : 180,
                height : 90,
                id : 'companyActiveImagePathShow',
                src : ''
            }, {
                fieldLabel : '重新上传图片',
                name : 'image_url_reload',
                xtype : 'filefield',
                vtype:'imageUpload',
                allowBlank : true
            }, {
                fieldLabel: '文字显示',
                name: 'content',
                allowBlank: true
            }, {
                fieldLabel: '跳转链接',
                name: 'href_url',
                allowBlank: true
            }, {
                fieldLabel: '温馨提示',
                xtype : 'displayfield',
                value : '大图片推荐大小为540x260像素，小图片推荐大小为300x260像素，第一张和最后一张为大图，其余为小图。这里请严格按照此大小，否则样式会乱。'
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('companyActiveModifyForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('companyActiveModifyForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function () {
                                    Ext.getCmp("company_active_modify_button").setDisabled(true);
                                    Ext.Msg.alert('成功', '修改成功。');
                                    Ext.getCmp('companyActiveModifyWindow').close();
                                    companyActiveSelModel.deselectAll();
                                    companyActiveStore.reload();
                                },
                                failure: function () {
                                    Ext.getCmp("company_active_modify_button").setDisabled(true);
                                    companyActiveSelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    })
});
