/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
var essayRender = function (val) {
    if (val == 1) {
        return '醉聚绵职';
    } else if (val == 2) {
        return '首善蓉城';
    }
    return val;
}

var essayStore = Ext.create('Ext.data.Store', {
    fields: ['id', 'title', 'author', 'create_date', 'sub_title', 'type', 'essay_content'],
    autoLoad: false,
    pageSize: 20,
    proxy: {
        extraParams: {},
        type: 'rest',
        url: '/structure/essay/controller/manager_listessay.php',
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

var essayAddContentForm = Ext.create('Ext.window.Window', {
    id : 'essayAddContentWindow',
    layout: 'fit',
    title: '增加文章内容',
    closeAction: 'hide',
    width: 600,
    height: 200,
    border: false,
    modal: true,
    items: [{
        id: 'essayAddContentForm',
        xtype: 'form',
        bodyPadding: 5,
        frame: true,
        layout: 'anchor',
        defaultType: 'textfield',
        fieldDefaults: {
            labelAlign: 'left',
            labelWidth: 80,
            anchor: '80%'
        },
        items: [{
            id : 'essayAddContentContent',
            fieldLabel: '内容',
            name: 'title',
            xtype : 'textarea',
            allowBlank: false
        }],
        buttons: [
            {
                text: '重置',
                handler: function () {
                    Ext.getCmp('essayAddContentForm').getForm().reset();
                }
            },
            {
                text: '确定',
                formBind: true, // only enabled once the form is valid
                disabled: false,
                handler: function () {
                    var form = Ext.getCmp('essayAddContentForm').getForm();
                    var content = Ext.getCmp('essayAddContentContent').getValue();
                    if (form.isValid()) {
                        var essayContentContainer = Ext.getCmp("essay_content_container");
                        var _checkField = new Ext.form.FieldSet(
                        {
                            items :
                                [{
                                    xtype : 'displayfield',
                                    value : content
                                }, {
                                    xtype : 'hidden',
                                    name : 'content[]',
                                    value : content
                                }, {
                                    xtype : 'hidden',
                                    name : 'content_type[]',
                                    value : 1
                                }, {
                                    xtype : 'button',
                                    text : '删除',
                                    handler : function()
                                    {
                                        _checkField.destroy();
                                    }
                                }]
                        });
                        essayContentContainer.add(_checkField);
                        Ext.getCmp('essayAddContentForm').getForm().reset();
                        Ext.getCmp('essayAddContentWindow').close();
                    }
                }
            }]
    }]
});

var essayAddImageForm = Ext.create('Ext.window.Window', {
    id : 'essayAddImageWindow',
    layout: 'fit',
    title: '增加文章图片',
    closeAction: 'hide',
    width: 600,
    height: 200,
    border: false,
    modal: true,
    items: [{
        id: 'essayAddImageForm',
        xtype: 'form',
        bodyPadding: 5,
        frame: true,
        url: '/structure/essay/controller/manager_essay_add_image.php',
        layout: 'anchor',
        defaultType: 'textfield',
        fieldDefaults: {
            labelAlign: 'left',
            labelWidth: 80,
            anchor: '80%'
        },
        items: [{
            id : 'essayAddImageContent',
            fieldLabel: '图片',
            name: 'image',
            xtype : 'filefield',
            allowBlank: false
        }],
        buttons: [
            {
                text: '上传',
                handler: function () {
                    var form = Ext.getCmp('essayAddImageForm').getForm();
                    if (form.isValid()) {
                        form.submit({
                            success: function (form1, action ,c, d) {
                                var essayContentContainer = Ext.getCmp("essay_content_container");
                                var _checkField = new Ext.form.FieldSet(
                                    {
                                        items : [{
                                            xtype: 'hidden',
                                            name : 'content[]',
                                            value: action.result.content
                                        }, {
                                            xtype : 'image',
                                            fieldLabel : '图片',
                                            height : 90,
                                            src : action.result.content
                                        }, {
                                            xtype : 'hidden',
                                            name : 'content_type[]',
                                            value : 2
                                        }, {
                                            xtype: 'button',
                                            text: '删除',
                                            handler: function () {
                                                _checkField.destroy();
                                            }
                                        }]
                                    });
                                essayContentContainer.add(_checkField);
                                Ext.getCmp('essayAddImageForm').getForm().reset();
                                Ext.getCmp('essayAddImageWindow').close();
                            },
                            failure: function (form, action) {
                                Ext.getCmp('essayAddImageWindow').close();
                                Ext.Msg.alert('失败', '请刷新后重试。');
                            }
                        });
                    }
                }
            }]
    }]
});

var essaySelModel = null;
function getEssaySelModel(){
    essaySelModel = Ext.create('Ext.selection.CheckboxModel', {
        mode: 'SINGLE',
        listeners: {
            beforeselect: function (catgegory, record, index, obj) {
            },
            selectionchange: function (sm, selections) {
            },
            select: function (essay, record, index, obj) {
                currentSel = record;
                Ext.getCmp("essay_modify_button").setDisabled(false);
                Ext.getCmp("essay_delete_button").setDisabled(false);
            }
        }
    });
    return essaySelModel;
}

Ext.define('MyDesktop.EssayWindow', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
        'Ext.data.ArrayStore',
        'Ext.util.Format',
        'Ext.grid.Panel',
        'Ext.grid.RowNumberer'
    ],

    id: 'essay-win',

    init: function () {
        this.launcher = {
            text: '文章管理'
        };
    },

    store: essayStore,

    createWindow: function () {
        var this_ = this;
        var desktop = this_.app.getDesktop();
        var win = desktop.getWindow('essay-win');
        if (!win) {
            win = desktop.createWindow({
                id: 'essay-win',
                title: '文章信息管理',
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
                        selModel: getEssaySelModel(),
                        columns: [
                            {
                                text: "id",
                                width: 30,
                                sortable: true,
                                dataIndex: 'id'
                            },
                            {
                                text: "标题",
                                width: 70,
                                sortable: true,
                                dataIndex: 'title'
                            },
                            {
                                text: "作者",
                                width: 70,
                                sortable: true,
                                dataIndex: 'author'
                            },
                            {
                                text: "创建时间",
                                width: 120,
                                sortable: true,
                                dataIndex: 'create_date'
                            },
                            {
                                text: "副标题",
                                width: 120,
                                sortable: true,
                                dataIndex: 'sub_title'
                            },
                            {
                                text: "类型",
                                width: 70,
                                sortable: true,
                                dataIndex: 'type',
                                renderer: essayRender
                            }
                        ]
                    }
                ],
                tbar: [{
                    id: 'essay_add_button',
                    text: '增加文章',
                    tooltip: '增加文章',
                    handler: function () {
                        this_.essayAddForm.show();
                    }
                }, '-', {
                    id: 'essay_modify_button',
                    text: '修改信息',
                    disabled: true,
                    tooltip: '修改某个文章填报的信息',
                    handler: function () {
                        /*Ext.getCmp('essayModifyForm').form.loadRecord(currentSel);
                        this_.essayModifyForm.show();*/
                    }
                }, '-', {
                    id: 'essay_delete_button',
                    text: '删除信息',
                    disabled: true,
                    tooltip: '删除某个文章填报的信息',
                    handler: function () {
                        /*Ext.MessageBox.confirm('确定', '是否要删除 ' + currentSel.data.name + ' ?', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/essay/controller/manager_delessay.php',
                                    params: {
                                        id: currentSel.data.id
                                    },
                                    success: function (response) {
                                        this_.store.reload();
                                        essaySelModel.deselectAll();
                                        Ext.getCmp("essay_modify_button").setDisabled(true);
                                        Ext.getCmp("essay_delete_button").setDisabled(true);
                                    }
                                });
                            }
                        });*/
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
    essayModifyForm: Ext.create('Ext.window.Window', {
        id : 'essayModifyWindow',
        layout: 'fit',
        title: '修改用户信息',
        closeAction: 'hide',
        width: 740,
        height: 480,
        border: false,
        modal: true,
        items: [{
            id: 'essayModifyForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            url: '/structure/essay/controller/manager_essay_modify.php',
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
                name: 'essay_nature',
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
                fieldLabel: '您认为文章会能为贵单位做些什么',
                name: 'descript',
                xtype : 'textfield',
                allowBlank: true
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('essayModifyForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('essayModifyForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function (form1, action) {
                                    Ext.getCmp("essay_modify_button").setDisabled(true);
                                    Ext.getCmp("essay_delete_button").setDisabled(true);
                                    Ext.Msg.alert('成功', '修改成功。');
                                    Ext.getCmp('essayModifyWindow').close();
                                    essaySelModel.deselectAll();
                                    essayStore.reload();
                                },
                                failure: function (form, action) {
                                    Ext.getCmp("essay_modify_button").setDisabled(true);
                                    Ext.getCmp("essay_delete_button").setDisabled(true);
                                    essaySelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    }),
    essayAddForm: Ext.create('Ext.window.Window', {
        id : 'essayAddWindow',
        layout: 'fit',
        title: '增加文章',
        closeAction: 'hide',
        width: 740,
        height: 480,
        border: false,
        modal: true,
        items: [{
            id: 'essayAddForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            autoScroll : true,
            url: '/structure/essay/controller/manager_essay_add.php',
            layout: 'anchor',
            defaultType: 'textfield',
            fieldDefaults: {
                labelAlign: 'left',
                labelWidth: 80,
                anchor: '80%'
            },
            items: [{
                fieldLabel: '类型',
                name: 'type',
                size: 5,
                allowBlank: false,
                xtype: 'combo',
                mode: 'local',
                value: '1',
                forceSelection: true,
                editable: false,
                typeAhead: true,
                displayField: 'name',
                valueField: 'value',
                queryMode: 'local',
                store: Ext.create('Ext.data.Store', {
                    fields: ['name', 'value'],
                    data: [{
                        name: '醉聚绵职',
                        value: '1'
                    }, {
                        name: '首善蓉城',
                        value: '2'
                    }]
                })
            }, {
                fieldLabel: '标题',
                name: 'title',
                allowBlank: false
            }, {
                fieldLabel: '作者',
                name: 'author',
                allowBlank: false
            }, {
                fieldLabel: '创建时间',
                xtype : 'datefield',
                format : 'Y-m-d',
                editable : false,
                name: 'create_date',
                allowBlank: false
            }, {
                fieldLabel: '副标题',
                name: 'sub_title',
                allowBlank: false
            }, {
                id : 'essay_content_container',
                title : '内容',
                xtype : 'fieldset',
                items : []
            }, {
                xtype : 'button',
                text : '插入段落',
                allowBlank: false,
                handler : function(){
                    essayAddContentForm.show();
                }
            }, {
                xtype : 'button',
                text : '插入图片',
                allowBlank: false,
                handler : function(){
                    essayAddImageForm.show();
                }
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        //Ext.getCmp('essayModifyForm').getForm().reset();
                        console.log(Ext.getCmp('essayAddForm').getForm().getValues());
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('essayAddForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function (form1, action) {
                                    Ext.getCmp("essay_modify_button").setDisabled(true);
                                    Ext.getCmp("essay_delete_button").setDisabled(true);
                                    Ext.Msg.alert('成功', '文章添加成功。');
                                    Ext.getCmp('essayAddWindow').close();
                                    essaySelModel.deselectAll();
                                    essayStore.reload();
                                },
                                failure: function (form, action) {
                                    Ext.getCmp("essay_modify_button").setDisabled(true);
                                    Ext.getCmp("essay_delete_button").setDisabled(true);
                                    essaySelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    })
});
