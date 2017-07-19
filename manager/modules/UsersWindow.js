/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
var sexRender = function (val) {
    if (val == 1) {
        return '<span style="color:green;">男</span>';
    } else if (val == 2) {
        return '<span style="color:red;">女</span>';
    } else {
        return '<span style="color:gray;">未知</span>';
    }
    return val;
}

var userStore = Ext.create('Ext.data.Store', {
    fields: ['id', 'name', 'sex', 'contact', 'school_date', 'open_id', 'area', 'department', 'major', 'career', 'career_type', 'company', 'descript'],
    autoLoad: false,
    pageSize: 20,
    proxy: {
        extraParams: {},
        type: 'rest',
        url: '/structure/user/controller/manager_listuser.php',// get_order_list.htm',
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

var currentSel = null;
var userSelModel = null;

function getUserSelModel(){
   userSelModel = Ext.create('Ext.selection.CheckboxModel', {
        mode: 'SINGLE',
        listeners: {
            beforeselect: function (catgegory, record, index, obj) {
            },
            selectionchange: function (sm, selections) {
            },
            select: function (user, record, index, obj) {
                currentSel = record;
                Ext.getCmp("user_modify_button").setDisabled(false);
                Ext.getCmp("user_delete_button").setDisabled(false);
            }
        }
    });
    return userSelModel;
}


Ext.define('MyDesktop.UsersWindow', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
        'Ext.data.ArrayStore',
        'Ext.util.Format',
        'Ext.grid.Panel',
        'Ext.grid.RowNumberer'
    ],

    id: 'user-win',

    init: function () {
        this.launcher = {
            text: '校友管理'
        };
    },

    store: userStore,

    createWindow: function () {
        var this_ = this;
        var desktop = this_.app.getDesktop();
        var win = desktop.getWindow('user-win');
        if (!win) {
            win = desktop.createWindow({
                id: 'user-win',
                title: '校友信息管理',
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
                        selModel: getUserSelModel(),
                        columns: [
                            {
                                text: "id",
                                width: 30,
                                sortable: true,
                                dataIndex: 'id'
                            },
                            {
                                text: "姓名",
                                width: 70,
                                sortable: true,
                                dataIndex: 'name'
                            },
                            {
                                text: "性別",
                                width: 45,
                                sortable: true,
                                dataIndex: 'sex',
                                renderer: sexRender
                            },
                            {
                                text: "联系方式",
                                width: 120,
                                sortable: true,
                                dataIndex: 'contact'
                            },
                            {
                                text: "所在城市",
                                width: 70,
                                sortable: true,
                                dataIndex: 'area'
                            },
                            {
                                text: "院系",
                                width: 70,
                                sortable: true,
                                dataIndex: 'department'
                            },
                            {
                                text: "专业和班级",
                                width: 70,
                                sortable: true,
                                dataIndex: 'major'
                            },
                            {
                                text: "职业/职位",
                                width: 70,
                                sortable: true,
                                dataIndex: 'career'
                            },
                            {
                                text: "行业类别",
                                width: 70,
                                sortable: true,
                                dataIndex: 'career_type'
                            },
                            {
                                text: "公司名称",
                                width: 70,
                                sortable: true,
                                dataIndex: 'company'
                            },
                            {
                                text: "openid",
                                width: 70,
                                sortable: true,
                                dataIndex: 'open_id'
                            },
                            {
                                text: "您认为校友会能为您做些什么",
                                width: 120,
                                sortable: true,
                                dataIndex: 'descript'
                            }
                        ]
                    }
                ],
                tbar: [{
                    id: 'user_modify_button',
                    text: '修改信息',
                    disabled: true,
                    tooltip: '修改某个校友填报的信息',
                    handler: function () {
                        Ext.getCmp('userModifyForm').form.loadRecord(currentSel);
                        this_.userModifyForm.show();
                    }
                }, '-', {
                    id: 'user_delete_button',
                    text: '删除信息',
                    disabled: true,
                    tooltip: '删除某个校友填报的信息',
                    handler: function () {
                        Ext.MessageBox.confirm('确定', '是否要删除 ' + currentSel.data.name + ' ?', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/user/controller/manager_deluser.php',
                                    params: {
                                        id: currentSel.data.id
                                    },
                                    success: function (response) {
                                        this_.store.reload();
                                        userSelModel.deselectAll();
                                        Ext.getCmp("user_modify_button").setDisabled(true);
                                        Ext.getCmp("user_delete_button").setDisabled(true);
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
    userModifyForm: Ext.create('Ext.window.Window', {
        id : 'userModifyWindow',
        layout: 'fit',
        title: '修改用户信息',
        closeAction: 'hide',
        width: 740,
        height: 480,
        border: false,
        modal: true,
        items: [{
            id: 'userModifyForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            url: '/structure/user/controller/manager_user_modify.php',
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
                fieldLabel: '用户姓名',
                name: 'name',
                allowBlank: false
            }, {
                fieldLabel: '性别',
                name: 'sex',
                size: 5,
                allowBlank: false,
                xtype: 'combo',
                mode: 'local',
                value: '0',
                forceSelection: true,
                editable: false,
                typeAhead: true,
                displayField: 'name',
                valueField: 'value',
                queryMode: 'local',
                store: Ext.create('Ext.data.Store', {
                    fields: ['name', 'value'],
                    data: [{
                        name: '未知',
                        value: '0'
                    }, {
                        name: '男',
                        value: '1'
                    }, {
                        name: '女',
                        value: '2'
                    }]
                })
            }, {
                fieldLabel: '联系方式',
                name: 'contact',
                allowBlank: false
            }, {
                fieldLabel: '所在城市',
                name: 'area',
                allowBlank: false
            }, {
                fieldLabel: '院系',
                name: 'department',
                allowBlank: true
            }, {
                fieldLabel: '专业和班级',
                name: 'major',
                allowBlank: false
            }, {
                fieldLabel: '职业/职位',
                name: 'career',
                allowBlank: false
            }, {
                fieldLabel: '行业类别',
                name: 'career_type',
                allowBlank: true
            }, {
                fieldLabel: '公司名称',
                name: 'company',
                allowBlank: true
            }, {
                fieldLabel: 'openid',
                name: 'open_id',
                xtype : 'displayfield'
            }, {
                fieldLabel: '您认为校友会能为您做些什么',
                name: 'descript',
                xtype : 'textfield',
                allowBlank: true
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('userModifyForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('userModifyForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function (form1, action) {
                                    Ext.Msg.alert('成功', '修改成功。');
                                    Ext.getCmp('userModifyWindow').close();
                                    userSelModel.deselectAll();
                                    userStore.reload();
                                },
                                failure: function (form, action) {
                                    userSelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    })
});
