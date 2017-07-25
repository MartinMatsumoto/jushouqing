/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.apply(Ext.form.VTypes, {
    imageUpload: function(val, field) {
        var fileName = /^.*\.(png|jpg|jpeg)$/i;
        return fileName.test(val);
    },
    imageUploadText: '图片文件必须是 png,jpg,jpeg 后缀的文件'
});

//设置图片路径
function getpicPathBannerModify()
{
    var PICTURE_URL = Ext.getCmp("image_url_modify").getValue();
    if (!Ext.isEmpty(PICTURE_URL))
    {
        Ext.getCmp("imagePathshow").src=PICTURE_URL;
    }else
    {
        Ext.getCmp("imagePathshow").getEl().dom.src = "";
    }
}

var bannerStore = Ext.create('Ext.data.Store', {
    fields: ['id', 'image_url', 'text1', 'text2', 'text3', 'text4'],
    autoLoad: false,
    pageSize: 20,
    proxy: {
        extraParams: {},
        type: 'rest',
        url: '/structure/banner/controller/manager_list_indexbanner.php',
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

var bannerSelModel = null;
function getBannerSelModel(){
    bannerSelModel = Ext.create('Ext.selection.CheckboxModel', {
        mode: 'SINGLE',
        listeners: {
            beforeselect: function (catgegory, record, index, obj) {
            },
            selectionchange: function (sm, selections) {
            },
            select: function (banner, record, index, obj) {
                currentSel = record;
                Ext.getCmp("banner_modify_button").setDisabled(false);
                Ext.getCmp("banner_delete_button").setDisabled(false);
            }
        }
    });
    return bannerSelModel;
}

Ext.define('MyDesktop.BannerWindow', {
    extend: 'Ext.ux.desktop.Module',
    requires: [
        'Ext.data.ArrayStore',
        'Ext.util.Format',
        'Ext.grid.Panel',
        'Ext.grid.RowNumberer'
    ],

    id: 'banner-win',

    init: function () {
        this.launcher = {
            text: 'banner管理'
        };
    },

    store: bannerStore,

    createWindow: function () {
        var this_ = this;
        var desktop = this_.app.getDesktop();
        var win = desktop.getWindow('banner-win');
        if (!win) {
            win = desktop.createWindow({
                id: 'banner-win',
                title: 'banner信息管理',
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
                        selModel: getBannerSelModel(),
                        columns: [
                            {
                                text: "id",
                                width: 30,
                                sortable: true,
                                dataIndex: 'id'
                            },
                            {
                                text: "图片地址",
                                width: 100,
                                sortable: true,
                                dataIndex: 'image_url'
                            },
                            {
                                text: "第一行字",
                                width: 140,
                                sortable: true,
                                dataIndex: 'text1'
                            },
                            {
                                text: "第二行字",
                                width: 140,
                                sortable: true,
                                dataIndex: 'text2'
                            },
                            {
                                text: "第三行字",
                                width: 140,
                                sortable: true,
                                dataIndex: 'text3'
                            },
                            {
                                text: "第四行字",
                                width: 140,
                                sortable: true,
                                dataIndex: 'text4'
                            }
                        ]
                    }
                ],
                tbar: [{
                    id: 'banner_add_button',
                    text: '增加banner',
                    tooltip: '增加一个banner',
                    handler: function () {
                        this_.bannerAddForm.show();
                    }
                }, '-', {
                    id: 'banner_modify_button',
                    text: '修改信息',
                    disabled: true,
                    tooltip: '修改某个banner填报的信息',
                    handler: function () {
                        Ext.getCmp('bannerModifyForm').form.loadRecord(currentSel);
                        getpicPathBannerModify();
                        this_.bannerModifyForm.show();
                    }
                }, '-', {
                    id: 'banner_delete_button',
                    text: '删除信息',
                    disabled: true,
                    tooltip: '删除某个banner填报的信息',
                    handler: function () {
                        Ext.MessageBox.confirm('确定', '是否要删除 ' + currentSel.data.name + ' ?', function (btn, text) {
                            if (btn == "yes") {
                                Ext.Ajax.request({
                                    url: '/structure/banner/controller/manager_delbanner.php',
                                    params: {
                                        id: currentSel.data.id
                                    },
                                    success: function () {
                                        this_.store.reload();
                                        bannerSelModel.deselectAll();
                                        Ext.getCmp("banner_modify_button").setDisabled(true);
                                        Ext.getCmp("banner_delete_button").setDisabled(true);
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
    bannerModifyForm: Ext.create('Ext.window.Window', {
        id : 'bannerModifyWindow',
        layout: 'fit',
        title: '修改Banner信息',
        closeAction: 'hide',
        width: 650,
        height: 400,
        border: false,
        modal: true,
        items: [{
            id: 'bannerModifyForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            url: '/structure/banner/controller/manager_banner_modify.php',
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
                id : 'image_url_modify',
                xtype : 'hidden'
            }, {
                xtype : 'image',
                fieldLabel : '原始图片',
                width : 180,
                height : 90,
                id : 'imagePathshow',
                src : ''
            }, {
                fieldLabel : '重新上传图片',
                name : 'image',
                xtype : 'filefield',
                vtype:'imageUpload',
                allowBlank : true
            }, {
                fieldLabel: '第一行字',
                name: 'text1',
                allowBlank: true
            }, {
                fieldLabel: '第二行字',
                name: 'text2',
                allowBlank: true
            }, {
                fieldLabel: '第三行字',
                name: 'text3',
                allowBlank: true
            }, {
                fieldLabel: '第四行字',
                name: 'text4',
                allowBlank: true
            }, {
                fieldLabel: '温馨提示',
                xtype : 'displayfield',
                value : '图片推荐大小为1350x580像素，所有图片高度请保持一致，请用photoshop转换为web所用格式，大小请压缩至500kb以内。'
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('bannerModifyForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('bannerModifyForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function () {
                                    Ext.getCmp("banner_modify_button").setDisabled(true);
                                    Ext.getCmp("banner_delete_button").setDisabled(true);
                                    Ext.Msg.alert('成功', '修改成功。');
                                    Ext.getCmp('bannerModifyWindow').close();
                                    bannerSelModel.deselectAll();
                                    bannerStore.reload();
                                },
                                failure: function () {
                                    Ext.getCmp("banner_modify_button").setDisabled(true);
                                    Ext.getCmp("banner_delete_button").setDisabled(true);
                                    bannerSelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    }),
    bannerAddForm: Ext.create('Ext.window.Window', {
        id : 'bannerAddWindow',
        layout: 'fit',
        title: '增加Banner',
        closeAction: 'hide',
        width: 650,
        height: 300,
        border: false,
        modal: true,
        items: [{
            id: 'bannerAddForm',
            xtype: 'form',
            bodyPadding: 5,
            frame: true,
            url: '/structure/banner/controller/manager_banner_add.php',
            layout: 'anchor',
            defaultType: 'textfield',
            fieldDefaults: {
                labelAlign: 'left',
                labelWidth: 80,
                anchor: '80%'
            },
            items: [{
                fieldLabel : '上传图片',
                name : 'image',
                xtype : 'filefield',
                vtype:'imageUpload',
                allowBlank : false
            }, {
                fieldLabel: '第一行字',
                name: 'text1',
                allowBlank: true
            }, {
                fieldLabel: '第二行字',
                name: 'text2',
                allowBlank: true
            }, {
                fieldLabel: '第三行字',
                name: 'text3',
                allowBlank: true
            }, {
                fieldLabel: '第四行字',
                name: 'text4',
                allowBlank: true
            }, {
                fieldLabel: '温馨提示',
                xtype : 'displayfield',
                value : '图片推荐大小为1350x580像素，所有图片高度请保持一致，请用photoshop转换为web所用格式，大小请压缩至500kb以内。'
            }],
            buttons: [
                {
                    text: '重置',
                    handler: function () {
                        Ext.getCmp('bannerAddForm').getForm().reset();
                    }
                },
                {
                    text: '提交',
                    formBind: true, // only enabled once the form is valid
                    disabled: false,
                    handler: function () {
                        var form = Ext.getCmp('bannerAddForm').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function (form1, action) {
                                    Ext.Msg.alert('成功', '添加成功。');
                                    Ext.getCmp('bannerAddWindow').close();
                                    bannerSelModel.deselectAll();
                                    bannerStore.reload();
                                },
                                failure: function (form, action) {
                                    bannerSelModel.deselectAll();
                                    Ext.Msg.alert('失败', '请刷新后重试。');
                                }
                            });
                        }
                    }
                }]
        }]
    })
});
