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
                Ext.getCmp("message_enable_button").setDisabled(false);
            }
        }
    });
    return messageSelModel;
}

/*---------------------------------------------回复内容------------------------------------------------*/
var messageReplyStore = Ext.create('Ext.data.Store', {
    fields: ['id', 'reply', 'openid', 'delete_', 'message_id', 'reply_id', 'wx_headimgurl', 'wx_nickname', 'create_date', 'name', 'user_headimgurl', 'reply_name', 'reply_user_headimgurl'],
    autoLoad: false,
    proxy: {
        extraParams: {},
        type: 'rest',
        url: '/structure/message/controller/manager_list_message_reply.php',
        reader: {
            type: 'json',
            root: 'content'// JSON数组对象名
        },
        actionMethods: {
            read: 'POST'
        }
    }
});

var selMessageReplyModel = Ext.create('Ext.selection.CheckboxModel',
{
    listeners:
    {
        beforeselect : function(catgegory, record, index, obj)
        {
        },
        selectionchange: function(sm, selections)
        {
        },
        select: function(user,record,index,obj)
        {
        }
    }
});

var messageReplyGrid =  Ext.create('Ext.grid.Panel',
    {
        title: '回复内容',
        store: messageReplyStore,
        columns:
            [
                { header: 'id',  dataIndex: 'id',width: 20},
                { header: '回复人', dataIndex: 'name',width: 120},
                { header: '回复人昵称', dataIndex: 'wx_nickname',width: 120},
                { header: '被回复人', dataIndex: 'reply_name',width: 100},
                { header: '是否删除', dataIndex: 'delete_', width: 60,renderer: deleteRender},
                { header: '回复时间', dataIndex: 'create_date',width: 120},
                { header: '回复内容', dataIndex: 'reply',width: 200}
            ],
        columnLines: true,
        selModel: selMessageReplyModel,
        bbar: Ext.create('Ext.PagingToolbar',
            {
                store: messageReplyStore,
                displayInfo: true,
                emptyMsg: "没有数据"
            })
    });

var messageReplyWin = Ext.create('Ext.window.Window',
    {
        layout: 'fit',
        title: '查看回复',
        closeAction: 'hide',
        width:740,
        height:480,
        border: false,
        items:[messageReplyGrid],
        listeners :
        {
            show :
            {
                fn : function()
                {
                    // 解决IE的htmleditor在winhide的时候不隐藏的问题
                    var editor = this.down('htmleditor');
                    if (editor)
                    {
                        editor.show();
                    }
                }
            },
            // 解决IE的htmleditor在winhide的时候不隐藏的问题
            hide : function()
            {
                var editor = this.down('htmleditor');
                if (editor)
                {
                    editor.hide();
                }
            }
        }
    });
/*---------------------------------------------结束  回复内容------------------------------------------------*/

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
            text: '留言管理'
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
                                text: "是否删除",
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
                        messageReplyStore.loadPage
                        (1, {
                            params: {
                                id: currentSel.data.id
                            }
                        });
                        messageReplyWin.show();
                        messageReplyWin.center();
                    }
                }, '-',{
                    id: 'message_modify_button',
                    text: '修改留言',
                    disabled: true,
                    tooltip: '修改留言信息',
                    handler: function () {
                        Ext.getCmp('messageModifyForm').form.loadRecord(currentSel);
                        this_.messageModifyForm.show();
                    }
                }, '-', {
                    id: 'message_delete_button',
                    text: '删除留言',
                    disabled: true,
                    tooltip: '删除留言',
                    handler: function () {
                        Ext.MessageBox.confirm('确定', '是否要删除这条留言？', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/message/controller/delete_message.php',
                                    params: {
                                        messageId: currentSel.data.id,
                                        openId : currentSel.data.openid
                                    },
                                    success: function (response) {
                                        this_.store.reload();
                                        messageSelModel.deselectAll();
                                        Ext.getCmp("message_modify_button").setDisabled(true);
                                        Ext.getCmp("message_show_reply_button").setDisabled(true);
                                        Ext.getCmp("message_delete_button").setDisabled(true);
                                        Ext.getCmp("message_enable_button").setDisabled(true);
                                    }
                                });
                            }
                        });
                    }
                }, '-', {
                    id: 'message_enable_button',
                    text: '启用留言',
                    disabled: true,
                    tooltip: '启用留言',
                    handler: function () {
                        Ext.MessageBox.confirm('确定', '是否要启用这条留言？', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/message/controller/enable_message.php',
                                    params: {
                                        messageId: currentSel.data.id,
                                        openId : currentSel.data.openid
                                    },
                                    success: function (response) {
                                        this_.store.reload();
                                        messageSelModel.deselectAll();
                                        Ext.getCmp("message_modify_button").setDisabled(true);
                                        Ext.getCmp("message_show_reply_button").setDisabled(true);
                                        Ext.getCmp("message_delete_button").setDisabled(true);
                                        Ext.getCmp("message_enable_button").setDisabled(true);
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
        title: '修改留言',
        closeAction: 'hide',
        width: 700,
        height: 180,
        border: false,
        modal: true,
        items: [{
            id: 'messageModifyForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            url: '/structure/message/controller/message_modify.php',
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
                name: 'openid'
            }, {
                fieldLabel: '留言信息',
                name: 'message',
                xtype : 'textareafield'
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
