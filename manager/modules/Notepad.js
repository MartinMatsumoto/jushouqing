/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
var deleteRender = function (val) {
    if (val == 0) {
        return '<span style="color:green;">否</span>';
    } else if (val == 1) {
        return '<span style="color:red;">是</span>';
    }
    return val;
}

var messageStore = Ext.create('Ext.data.Store', {
    fields: ['id', 'openid', 'message', 'create_date', 'delete_', 'name', 'sex', 'wx_nickname', 'wx_headimgurl', 'user_wx_headimgurl'],
    autoLoad: false,
    pageSize: 20,
    proxy: {
        extraParams: {},
        type: 'rest',
        url: '/structure/message/controller/manager_list_message.php',
        reader: {
            type: 'json',
            root: 'content',// JSON数组对象名
            totalProperty: 'count'// 数据集记录总数
        },
        actionMethods: {
            read: 'POST'
        },
        limitParam: 'pageSize',
        //pageParam : 'currentPage',
        startParam: 'begin'
    }
});

var messageSelModel = null;
function getMessageSelModel(){
    messageSelModel = Ext.create('Ext.selection.CheckboxModel', {
        mode: 'SINGLE',
        listeners: {
            beforeselect: function (catgegory, record, index, obj) {
            },
            selectionchange: function (sm, selections) {
            },
            select: function (message, record, index, obj) {
                currentSel = record;
                Ext.getCmp("message_modify_button").setDisabled(false);
                Ext.getCmp("message_delete_button").setDisabled(false);
                Ext.getCmp("message_show_reply_button").setDisabled(false);
            }
        }
    });
    return messageSelModel;
}

Ext.define('MyDesktop.Notepad', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
        'Ext.data.ArrayStore',
        'Ext.util.Format',
        'Ext.grid.Panel',
        'Ext.grid.RowNumberer'
    ],

    id: 'notepad-win',

    init: function () {
        this.launcher = {
            text: '校友管理'
        };
    },

    store: messageStore,

    createWindow: function () {
        var this_ = this;
        var desktop = this_.app.getDesktop();
        var win = desktop.getWindow('notepad-win');
        if (!win) {
            win = desktop.createWindow({
                id: 'notepad-win',
                title: '留言板管理管理',
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
                        selModel: getMessageSelModel(),
                        columns: [
                            {
                                text: "id",
                                width: 30,
                                sortable: true,
                                dataIndex: 'id'
                            },
                            {
                                text: "留言时间",
                                width: 150,
                                sortable: true,
                                dataIndex: 'create_date'
                            },
                            {
                                text: "是否已删除",
                                width: 70,
                                sortable: true,
                                dataIndex: 'delete_',
                                renderer: deleteRender
                            },
                            {
                                text: "留言人姓名",
                                width: 120,
                                sortable: true,
                                dataIndex: 'name'
                            },
                            {
                                text: "留言人微信名",
                                width: 120,
                                sortable: true,
                                dataIndex: 'wx_nickname'
                            },
                            {
                                text: "留言",
                                width: 200,
                                sortable: true,
                                dataIndex: 'message'
                            }
                        ]
                    }
                ],
                tbar: [{
                    id: 'message_show_reply_button',
                    text: '查看回复',
                    disabled: true,
                    tooltip: '查看该留言下的回复',
                    handler: function () {
                        return;
                        Ext.getCmp('messageModifyForm').form.loadRecord(currentSel);
                        this_.messageModifyForm.show();
                    }
                }, '-',{
                    id: 'message_modify_button',
                    text: '修改信息',
                    disabled: true,
                    tooltip: '修改某个校友填报的信息',
                    handler: function () {
                        return;
                        Ext.getCmp('messageModifyForm').form.loadRecord(currentSel);
                        this_.messageModifyForm.show();
                    }
                }, '-', {
                    id: 'message_delete_button',
                    text: '删除信息',
                    disabled: true,
                    tooltip: '删除某个校友填报的信息',
                    handler: function () {
                        return;
                        Ext.MessageBox.confirm('确定', '是否要删除 ' + currentSel.data.name + ' ?', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/message/controller/manager_delmessage.php',
                                    params: {
                                        id: currentSel.data.id
                                    },
                                    success: function (response) {
                                        this_.store.reload();
                                        messageSelModel.deselectAll();
                                        Ext.getCmp("message_modify_button").setDisabled(true);
                                        Ext.getCmp("message_show_reply_button").setDisabled(true);
                                        Ext.getCmp("message_delete_button").setDisabled(true);
                                    }
                                });
                            }
                        });
                    }
                }],
                bbar: Ext.create('Ext.PagingToolbar', {
                    store: this.store,
                    displayInfo: true,
                    displayMsg: '显示 {0} - {1} 条，共计 {2} 条',
                    emptyMsg: "没有数据"
                })
            });
            this.store.load();
        }
        return win;
    },
    currentSel: null,
    messageModifyForm: Ext.create('Ext.window.Window', {
        id : 'messageModifyWindow',
        layout: 'fit',
        title: '修改用户信息',
        closeAction: 'hide',
        width: 740,
        height: 480,
        border: false,
        modal: true,
        items: [{
            id: 'messageModifyForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            url: '/structure/message/controller/manager_message_modify.php',
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
                name: 'open_id'
            }, {
                fieldLabel: '企业全称',
                name: 'name',
                allowBlank: false
            }, {
                fieldLabel: '行业类别',
                name: 'career_type',
                allowBlank: false
            }, {
                fieldLabel: '企业性质',
                name: 'message_nature',
                allowBlank: false
            }, {
                fieldLabel: '办公地址',
                name: 'location',
                allowBlank: false
            }, {
                fieldLabel: '联系人',
                name: 'contactor',
                allowBlank: false
            }, {
                fieldLabel: '联系电话',
                name: 'tel',
                allowBlank: false
            }, {
                fieldLabel: '邮箱',
                name: 'email',
                allowBlank: false
            }, {
                fieldLabel: '您认为校友会能为贵单位做些什么',
                name: 'descript',
                xtype : 'textfield',
                allowBlank: true
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('messageModifyForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('messageModifyForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function (form1, action) {
                                    Ext.Msg.alert('成功', '修改成功。');
                                    Ext.getCmp('messageModifyWindow').close();
                                    messageSelModel.deselectAll();
                                    messageStore.reload();
                                },
                                failure: function (form, action) {
                                    messageSelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    })
});
