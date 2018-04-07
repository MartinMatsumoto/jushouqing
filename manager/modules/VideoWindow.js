/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
var videoRender = function (val) {
    if (val == "qq") {
        return '腾讯视频';
    }
    return val;
}

var videoContentContainerId = "";

var videoStore = Ext.create('Ext.data.Store', {
    fields: ['id', 'title', 'author', 'create_date', 'sub_title', 'type', 'delete_', 'url'],
    autoLoad: false,
    pageSize: 20,
    proxy: {
        extraParams: {},
        type: 'rest',
        url: '/structure/video/controller/manager_listvideo.php',
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

var videoSelModel = null;
function getVideoSelModel(){
    videoSelModel = Ext.create('Ext.selection.CheckboxModel', {
        mode: 'SINGLE',
        listeners: {
            beforeselect: function (catgegory, record, index, obj) {
            },
            selectionchange: function (sm, selections) {
            },
            select: function (video, record, index, obj) {
                currentSel = record;
                Ext.getCmp("video_modify_button").setDisabled(false);
                Ext.getCmp("video_delete_button").setDisabled(false);
                Ext.getCmp("video_enable_button").setDisabled(false);
            }
        }
    });
    return videoSelModel;
}

Ext.define('MyDesktop.VideoWindow', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
        'Ext.data.ArrayStore',
        'Ext.util.Format',
        'Ext.grid.Panel',
        'Ext.grid.RowNumberer'
    ],

    id: 'video-win',

    init: function () {
        this.launcher = {
            text: '视频管理'
        };
    },

    store: videoStore,

    createWindow: function () {
        var this_ = this;
        var desktop = this_.app.getDesktop();
        var win = desktop.getWindow('video-win');
        if (!win) {
            win = desktop.createWindow({
                id: 'video-win',
                title: '视频信息管理',
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
                        selModel: getVideoSelModel(),
                        columns: [
                            {
                                text: "id",
                                width: 30,
                                sortable: true,
                                dataIndex: 'id'
                            },
                            {
                                text: "标题",
                                width: 140,
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
                                renderer: videoRender
                            },
                            {
                                text: "链接",
                                width: 120,
                                sortable: true,
                                dataIndex: 'url'
                            },
                            {
                                text: "是否删除",
                                width: 70,
                                sortable: true,
                                dataIndex: 'delete_',
                                renderer: deleteRender
                            }
                        ]
                    }
                ],
                tbar: [{
                    id: 'video_add_button',
                    text: '增加视频',
                    tooltip: '增加视频',
                    handler: function () {
                        this_.videoAddForm.show();
                    }
                }, '-', {
                    id: 'video_modify_button',
                    text: '修改信息',
                    disabled: true,
                    tooltip: '修改某个视频填报的信息',
                    handler: function () {
                        Ext.getCmp('videoModifyForm').form.loadRecord(currentSel);
                        this_.videoModifyForm.show();
                    }
                }, '-', {
                    id: 'video_delete_button',
                    text: '删除视频',
                    disabled: true,
                    tooltip: '删除某个视频填报的信息',
                    handler: function () {
                        Ext.MessageBox.confirm('确定', '是否要删除视频?', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/video/controller/manager_delevideo.php',
                                    params: {
                                        id: currentSel.data.id
                                    },
                                    success: function (response) {
                                        this_.store.reload();
                                        videoSelModel.deselectAll();
                                        Ext.getCmp("video_modify_button").setDisabled(true);
                                        Ext.getCmp("video_delete_button").setDisabled(true);
                                        Ext.getCmp("video_enable_button").setDisabled(true);
                                    }
                                });
                            }
                        });
                    }
                }, '-', {
                    id: 'video_enable_button',
                    text: '恢复视频',
                    disabled: true,
                    tooltip: '恢复某个视频填报的信息',
                    handler: function () {
                        Ext.MessageBox.confirm('确定', '是否要恢复视频?', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/video/controller/manager_enablevideo.php',
                                    params: {
                                        id: currentSel.data.id
                                    },
                                    success: function (response) {
                                        this_.store.reload();
                                        videoSelModel.deselectAll();
                                        Ext.getCmp("video_modify_button").setDisabled(true);
                                        Ext.getCmp("video_delete_button").setDisabled(true);
                                        Ext.getCmp("video_enable_button").setDisabled(true);
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
    videoModifyForm: Ext.create('Ext.window.Window', {
        id : 'videoModifyWindow',
        layout: 'fit',
        title: '修改视频信息',
        closeAction: 'hide',
        width: 740,
        height: 480,
        border: false,
        modal: true,
        listeners :
            {
                show :
                    {
                        fn : function()
                        {
                            videoContentContainerId = "video_modify_content_container";
                        }
                    },
                hide : {
                    fn : function(){
                    }
                }
            },
        items: [{
            id: 'videoModifyForm',
            autoScroll : true,
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            url: '/structure/video/controller/manager_video_modify.php',
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
                        name: '腾讯视频',
                        value: 'qq'
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
                fieldLabel: '链接',
                name: 'url',
                allowBlank: false
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('videoModifyForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('videoModifyForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function (form1, action) {
                                    Ext.getCmp("video_modify_button").setDisabled(true);
                                    Ext.getCmp("video_delete_button").setDisabled(true);
                                    Ext.getCmp("video_enable_button").setDisabled(true);
                                    Ext.getCmp('videoModifyForm').getForm().reset();
                                    Ext.Msg.alert('成功', '视频修改成功。');
                                    Ext.getCmp('videoModifyWindow').close();
                                    videoSelModel.deselectAll();
                                    videoStore.reload();
                                },
                                failure: function (form, action) {
                                    Ext.getCmp("video_modify_button").setDisabled(true);
                                    Ext.getCmp("video_delete_button").setDisabled(true);
                                    Ext.getCmp("video_enable_button").setDisabled(true);
                                    videoSelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    }),
    videoAddForm: Ext.create('Ext.window.Window', {
        id : 'videoAddWindow',
        layout: 'fit',
        title: '增加视频',
        closeAction: 'hide',
        width: 740,
        height: 480,
        border: false,
        modal: true,
        listeners :
            {
                show :
                    {
                        fn : function()
                        {
                            videoContentContainerId = "url_container";
                        }
                    }
            },
        items: [{
            id: 'videoAddForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            autoScroll : true,
            url: '/structure/video/controller/manager_video_add.php',
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
                        name: '腾讯视频',
                        value: 'qq'
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
                fieldLabel: '链接',
                name: 'url',
                allowBlank: false
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('videoAddForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('videoAddForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function (form1, action) {
                                    Ext.getCmp("video_modify_button").setDisabled(true);
                                    Ext.getCmp("video_delete_button").setDisabled(true);
                                    Ext.getCmp("video_enable_button").setDisabled(true);
                                    Ext.getCmp('videoAddForm').getForm().reset();
                                    Ext.Msg.alert('成功', '视频添加成功。');
                                    Ext.getCmp('videoAddWindow').close();
                                    videoSelModel.deselectAll();
                                    videoStore.reload();
                                },
                                failure: function (form, action) {
                                    Ext.getCmp("video_modify_button").setDisabled(true);
                                    Ext.getCmp("video_delete_button").setDisabled(true);
                                    Ext.getCmp("video_enable_button").setDisabled(true);
                                    videoSelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    })
});
