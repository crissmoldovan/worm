/*!
 * Ext JS Library 3.2.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

//
// This is the main layout definition.
//

function TabManager(){
	this.tabs = [];
	this.ds = [];
	this.grids = [];
	this.getTabContainer = function() {
		return Ext.getCmp('center_content');
	};
	
	this.createTab = function(tabID, title){
		if (! this.tabs[tabID]){
			
			var table_sm = new xg.CheckboxSelectionModel({
					listeners: {
						selectionchange: function(){
						
						}
					}
				});
			var class_sm = new xg.CheckboxSelectionModel({checkOnly: true});
			
			
			this.getTabContainer().add({
				id: tabID,
	            title: title,
	            iconCls: 'tabs',
	            closable:true,
	            layout:'border',
	            items: [
	            new xg.GridPanel({
                	id: "table_grid_"+tabID,
                	title: 'Tables',
                	loadMask: true,
	                width: 250,
	                region: "west",
	                split:true,
	    			margins: '0 0 5 1',
	    	        minSize: 100,
	    	        maxSize: 500,
                    store: new Ext.data.JsonStore({
                        // store configs
                    	autoLoad: true,
                        autoDestroy: true,
                        url: BASE_URL+'/db/table/list/format/json/host/'+tabID.replace("tab_", ""),
                        storeId: 'table_store_'+tabID,
                        // reader configs
                        root: 'tables',
                        idProperty: 'name',
                        fields: ['name'],
                        listeners:{
                            load: function () {
                    			Ext.getCmp("table_grid_"+tabID).getSelectionModel().selectAll();
                    			
                    			var selectedTables = Ext.getCmp("table_grid_"+tabID).getSelectionModel().getSelections();
                	    		if (selectedTables.length == 0) Ext.Msg.alert("Table Selection Error", "Please select at least a table!");
                	    		var tableNames = [];
                	    		for(var i=0; i<selectedTables.length; i++){
                	    			tableNames.push(selectedTables[i].data.name);
                	    		}
                	    		
                	    		var classStore = tabManager.ds['class_store_'+tabID];
                	    		
                	    		classStore.load({
                	    			params:{
                	    				tableNames: Ext.util.JSON.encode(tableNames)
                	    			}
                	    		});
                    		}
                    	}
                    }),
                    cm: new xg.ColumnModel({
                        defaults: {
                            width: 120,
                            sortable: true
                        },
                        columns: [
                            table_sm,
                            {id:'name',header: "Table Name", width: 200, dataIndex: 'name'}
                        ]
                    }),
                    sm: table_sm,
                    columnLines: true,
                    iconCls:'icon-grid',
                    bbar: new Ext.Toolbar({
                    	items: [
                    	    '->',
                    	    {
                                // xtype: 'button', // default for Toolbars, same as 'tbbutton'
                                text: 'Use Selected Tables',
                                handler: function(){
                    	    		var selectedTables = Ext.getCmp("table_grid_"+tabID).getSelectionModel().getSelections();
                    	    		if (selectedTables.length == 0) Ext.Msg.alert("Table Selection Error", "Please select at least a table!");
                    	    		var tableNames = [];
                    	    		for(var i=0; i<selectedTables.length; i++){
                    	    			tableNames.push(selectedTables[i].data.name);
                    	    		}
                    	    		
                    	    		var classStore = tabManager.ds['class_store_'+tabID];
                    	    		
                    	    		classStore.load({
                    	    			params:{
                    	    				tableNames: Ext.util.JSON.encode(tableNames)
                    	    			}
                    	    		});
                    	    	}
                            }
                    	]
                    })
                }),{
	                region: "center",
	                margins: '0 0 5 1',
	                layout: "columnfit",
	                border: false,
	                items: [
	                new xg.GridPanel({
	                	id: "class_grid_"+tabID,
	                	columnWidth: .50,
	                	loadMask: true,
	                    store: new Ext.data.JsonStore({
	                        // store configs
	                        autoDestroy: true,
	                        url: BASE_URL+'/code/class/list/format/json/host/'+tabID.replace("tab_", ""),
	                        storeId: 'class_store_'+tabID,
	                        // reader configs
	                        root: 'classes',
	                        idProperty: 'path',
	                        fields: ['name', 'path', 'table']
	                    }),
	                    cm: new xg.ColumnModel({
	                        defaults: {
	                            width: 120,
	                            sortable: true
	                        },
	                        columns: [
	                            class_sm,
	                            {id:'name',header: "ClassName", width: 150, dataIndex: 'name'},
	                            {id:'path',header: "Path", width: 150, dataIndex: 'path'},
	                            {id:'preview',header: "Code Preview", width: 150, dataIndex: 'name', renderer: detailsRenderer }
	                            
//	                            {header: "Last Updated", width: 135, renderer: Ext.util.Format.dateRenderer('m/d/Y'), dataIndex: 'lastChange'}
	                        ]
	                    }),
	                    sm: class_sm,
	                    columnLines: true,
	                   
	                    title:'Classes',
	                    iconCls:'icon-grid',
	                }),
	                {
	                	title: 'Project Details',
	                	columnWidth: .50,
	                	bodyStyle: 'padding-bottom:15px;background:#eee;',
	            		autoScroll: true,
	                	autoLoad: BASE_URL+"/code/index/index/format/html/host/"+tabID.replace("tab_", "")
	                }]
	            }]

	        });
			
			this.tabs[tabID] = Ext.getCmp(tabID);
			this.grids["class_grid_"+tabID] = Ext.getCmp("class_grid_"+tabID);
			this.ds['class_store_'+tabID] = Ext.StoreMgr.lookup('class_store_'+tabID);
			this.grids["table_grid_"+tabID] = Ext.getCmp("table_grid_"+tabID);
			this.ds['table_store_'+tabID] = Ext.StoreMgr.lookup('table_store_'+tabID);
			
			this.tabs[tabID].on('beforeclose', function(n){
				tabManager.removeTab(n.id);
			});
		}
		
		return this.tabs[tabID];
	};
	this.getTab = function(tabID){
		if (this.tabs[tabID]){
			return this.tabs[tabID];
		}
		else return false;
	};
	
	this.showTab = function (tabID){
		this.getTab(tabID).show();
	};
	
	this.removeTab = function (tabID){
		delete(this.tabs[tabID]);
		delete(this.grids["class_grid_"+tabID]);
		delete(this.ds['class_store_'+tabID]);
	};
	
	this.getGrid = function(tabID){
		return this.grids[tabID];
	};
	this.getActiveTab = function(){
		return this.getTabContainer().getActiveTab();
	};
	
};


var newConnectionWindow;
var previewWindow;
var tabManager = new TabManager();

var xg = Ext.grid;

var sm = new xg.CheckboxSelectionModel();

function showPreviewWindow(className, path, table, host){
	
	// get host info (by getting the active tab
	var host = tabManager.getActiveTab().id.replace("tab_", "");
	
	if(!previewWindow){
		previewWindow = new Ext.Window({
			title: "Preview & DB Overview",
            layout:'fit',
            width:700,
            height:500,
            closeAction:'close',
            plain: true,

            items: [
				new Ext.TabPanel({
					id: "preview_tabs",
					margins: '2 5 5 0',
				    resizeTabs:true, // turn on tab resizing
				    minTabWidth: 115,
				    tabWidth:185,
				    enableTabScroll:true,
				    defaults: {autoScroll:true},
				    activeTab: 0,
				    items:[
						{
							id: "model_preview",
						    title: 'Model',
						    html: "",
						    listeners: {
								activate: function() {
									Ext.getCmp('model_preview').load({
									    url: BASE_URL+"/code/index/preview/format/html/type/model/host/"+host,
									    params: {table: table}, // or a URL encoded string
									    discardUrl: false,
									    text: 'Loading...',
									    timeout: 300,
									    scripts: true
									});
								}
							}
						},
						{
							id: "da_preview",
						    title: 'Data Mapper',
						    html: "",
						    listeners: {
								activate: function() {
									Ext.getCmp('da_preview').load({
									    url: BASE_URL+"/code/index/preview/format/html/type/da/host/"+host,
									    params: {table: table}, // or a URL encoded string
									    discardUrl: false,
									    text: 'Loading...',
									    timeout: 300,
									    scripts: true
									});
								}
							}
						}
				    ]
				})
            ],

            buttons: [{
                text: 'Close',
                handler: function(){
            	previewWindow.destroy();
            	previewWindow = null;
                }
            }]
        });
		
		
    }
	previewWindow.show(this);
	
	
	
	
}
function detailsRenderer(dataValue, metaData, record, rowIndex, colIndex, ds){
	return "<a href='javascript: void(0)' onclick='showPreviewWindow(\""+record.data.name+"\", \""+record.data.path+"\", \""+record.data.table+"\")' >[Preview]</a>";
}

function showDetailsWindow(){
	
}

Ext.onReady(function(){
	
	Ext.QuickTips.init();
	
	var contentPanel =
		new Ext.TabPanel({
			id: "center_content",
			region: 'center', // this is what makes this panel into a region within the containing layout
			margins: '2 5 5 0',
	        resizeTabs:true, // turn on tab resizing
	        minTabWidth: 115,
	        tabWidth:135,
	        enableTabScroll:true,
	        defaults: {autoScroll:true},
	        plugins: new Ext.ux.TabCloseMenu(),
	        activeTab: 0,
	        items:[
				{
				    title: 'Welcome',
				    contentEl: 'welcome',
				    closable:true
				}
	        ]
	    });
    
	// Go ahead and create the TreePanel now so that we can use it below
    var treePanel = new Ext.tree.TreePanel({
    	id: 'tree-panel',
    	title: 'Database Connections',
        region:'north',
        split: true,
        height: 300,
        minSize: 150,
        autoScroll: true,
        // tree-specific configs:
        rootVisible: false,
        lines: false,
        singleExpand: true,
        useArrows: true,
        
        loader: new Ext.tree.TreeLoader({
            dataUrl:BASE_URL+'/db/host/list/'
        }),
        
        root: new Ext.tree.AsyncTreeNode(),
        tbar: [{
            icon: BASE_URL+"/images/icons/database_add.png",
            tooltip: "Add New Connection",
            handler: function(){
        		showNewConnectionWindow();
        	}
        },
        {
            icon: BASE_URL+"/images/icons/database_refresh.png",
            tooltip: "Refresh Connections List",
            handler: function (){
        	
        		var tree = Ext.getCmp('tree-panel');
        		tree.getLoader().load(tree.root);

        	}
        }
        ]

    });
    
    treePanel.on('click', function(n){
    	var sn = this.selModel.selNode || {}; // selNode is null on initial selection
    	if(n.leaf && n.id != sn.id){  // ignore clicks on folders and currently selected node 
    		showHostDetails(n.id);
    	}
    });
    
    treePanel.on('dblclick', function(n){
    	var tab = tabManager.createTab("tab_"+n.id, n.text);
    	tab.show();
    });
	// Assign the changeLayout function to be called on tree node click.
//    treePanel.on('click', function(n){
//    	var sn = this.selModel.selNode || {}; // selNode is null on initial selection
//    	if(n.leaf && n.id != sn.id){  // ignore clicks on folders and currently selected node 
//    		Ext.getCmp('content-panel').layout.setActiveItem(n.id + '-panel');
//    		if(!detailEl){
//    			var bd = Ext.getCmp('details-panel').body;
//    			bd.update('').setStyle('background','#fff');
//    			detailEl = bd.createChild(); //create default empty div
//    		}
//    		detailEl.hide().update(Ext.getDom(n.id+'-details').innerHTML).slideIn('l', {stopFx:true,duration:.2});
//    	}
//    });
    
	// This is the Details panel that contains the description for each example layout.
	var detailsPanel = {
		id: 'details-panel',
        title: 'Details',
        region: 'center',
        bodyStyle: 'padding-bottom:15px;background:#eee;',
		autoScroll: true,
		html: '<p>select a db connector from above</p>'
    };
	
	// Finally, build the main layout once all the pieces are ready.  This is also a good
	// example of putting together a full-screen BorderLayout within a Viewport.
    new Ext.Viewport({
		layout: 'border',
		title: 'Ext Layout Browser',
		items: [{
			xtype: 'box',
			region: 'north',
			applyTo: 'header',
			height: 30
		},{
			layout: 'border',
	    	id: 'layout-browser',
	        region:'west',
	        border: false,
	        split:true,
			margins: '2 0 5 5',
	        width: 275,
	        minSize: 100,
	        maxSize: 500,
			items: [treePanel, detailsPanel]
		},
			contentPanel
		],
        renderTo: Ext.getBody()
    });
});


function showHostDetails(hostID){
	Ext.getCmp("details-panel").load(BASE_URL+"/db/host/details/format/html/id/"+hostID);
}

function showNewConnectionWindow(){
	if(!newConnectionWindow){
		newConnectionWindow = new Ext.Window({
			title: "Add New Connection",
            layout:'form',
            width:350,
            height:300,
            closeAction:'hide',
            plain: true,
            defaults: {width: 180},
            defaultType: 'textfield',

            items: [
                {
                    fieldLabel: 'Name',
                    name: 'name',
                    allowBlank:false
                },{
                    fieldLabel: 'Host',
                    name: 'host',
                    allowBlank:false
                },{
                    fieldLabel: 'Port',
                    name: 'port',
                    value: 3306,
                    allowBlank:false
                }, {
                    fieldLabel: 'User',
                    name: 'user',
                    allowBlank:false
                },{
                    fieldLabel: 'Password',
                    name: 'pass',
                    allowBlank:false
                },{
                    fieldLabel: 'Schema',
                    name: 'schema',
                    allowBlank:false
                },{
                    fieldLabel: 'Charset',
                    name: 'charset',
                    allowBlank:false,
                    value: "utf8"
                },{
                    fieldLabel: 'Connector',
                    name: 'connector',
                    value: 'Pdo_Mysql',
                    allowBlank:false
                }
            ],

            buttons: [{
                text:'Submit',
                disabled:true
            },{
                text: 'Close',
                handler: function(){
                    win.hide();
                }
            }]
        });
    }
	newConnectionWindow.show(this);
}

function generate(host){
	
	var tableNames = getSelectedClasses(host);
	var output = $("#output_"+host).val();
	var url =  BASE_URL+"/code/index/generate/format/html/host/"+host;
	$('#log_'+host).html("<br /><br /><center><img src='"+BASE_URL+"/js/ext/resources/images/default/grid/loading.gif'</center>");
	var postData = {};
	if (tableNames.length <= 0) {
		Ext.Msg.alert("Class Selection Error", "Please select at least one class!");
	}else{
		postData.tableNames = Ext.util.JSON.encode(tableNames);
		postData.uniqueID = $("#unique_"+host).val();
		
		if ($("#custom_output_chk_"+host+":checked").val() == "on"){
			postData.output = $("#custom_output_"+host).val();
		}else{
			postData.output = $("#default_output_"+host).val();
		}
		$.post(url, postData, function(data) {
			$('#log_'+host).html(data);
		});
	}
	
}

function showTextBoxes(host){
	$("#models_span_"+host).hide();
	$("#da_span_"+host).hide();
	$("#managers_span_"+host).hide();
	
	$("#models_output_"+host).show();
	$("#da_output_"+host).show();
	$("#managers_output_"+host).show();
}

function showSpans(host){
	$("#models_span_"+host).show();
	$("#da_span_"+host).show();
	$("#managers_span_"+host).show();
	
	$("#models_output_"+host).hide();
	$("#da_output_"+host).hide();
	$("#managers_output_"+host).hide();
}

function setPaths(host){
	if ($("#custom_output_chk_"+host+":checked").val() == "on"){
		$("#models_output_"+host).val($("#custom_output_"+host).val()+"/models");
		$("#da_output_"+host).val($("#custom_output_"+host).val()+"/da");
		$("#managers_output_"+host).val($("#custom_output_"+host).val()+"/managers");
	}else{
		$("#models_output_"+host).val($("#default_output_"+host).val()+"/"+$("#unique_"+host).val()+"/models");
		$("#da_output_"+host).val($("#default_output_"+host).val()+"/"+$("#unique_"+host).val()+"/da");
		$("#managers_output_"+host).val($("#default_output_"+host).val()+"/"+$("#unique_"+host).val()+"/managers");
	}
	setSpans(host);
}

function changeCustomPath(chk, host){
	if(chk.checked){
		$("#custom_output_"+host).removeAttr("disabled");
		$("#models_output_"+host).removeAttr("disabled");
		$("#da_output_"+host).removeAttr("disabled");
		$("#managers_output_"+host).removeAttr("disabled");
		
		showTextBoxes(host);
	}else{
		$("#custom_output_"+host).attr("disabled","disabled");
		$("#models_output_"+host).attr("disabled","disabled");
		$("#da_output_"+host).attr("disabled","disabled");
		$("#managers_output_"+host).attr("disabled","disabled");
		
		showSpans(host);
	}
	setPaths(host);
}

function setSpans(host){
	$("#models_span_"+host).html($("#models_output_"+host).val());
	$("#da_span_"+host).html($("#da_output_"+host).val());
	$("#managers_span_"+host).html($("#managers_output_"+host).val());
}

function getSelectedClasses(tabID){
	var selectedClasses = Ext.getCmp("class_grid_tab_"+tabID).getSelectionModel().getSelections();
	var tableNames = [];
	for(var i=0; i<selectedClasses.length; i++){
		tableNames.push(selectedClasses[i].data.table);
	}

	return tableNames;
}
