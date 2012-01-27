// vim: ts=4:sw=4:nu:fdc=4:nospell
/**
 * Ext.ux.layout.ColumnFitLayout Extension Class for Ext 2.x Library
 *
 * Sets height of columns to take the whole available height of the container.
 *
 * @author    Ing. Jozef Sakalos
 * @copyright (c) 2008, Ing. Jozef Sakalos
 * @version $Id: Ext.ux.layout.ColumnFitLayout.js 362 2008-09-18 12:48:25Z jozo $
 *
 * @license Ext.ux.layout.ColumnFitLayout is licensed under the terms of
 * the Open Source LGPL 3.0 license.  Commercial use is permitted to the extent
 * that the code/component(s) do NOT become part of another Open Source or Commercially
 * licensed development library or toolkit without explicit permission.
 * 
 * License details: http://www.gnu.org/licenses/lgpl.html
 */

/*global Ext */

Ext.ns('Ext.ux.layout');

/**
 * @class Ext.ux.layout.ColumnFitLayout
 * @extends Ext.layout.ColumnLayout
 */
Ext.ux.layout.ColumnFitLayout  = Ext.extend(Ext.layout.ColumnLayout, {
    onLayout:function(ct, target) {
        // call parent
        Ext.ux.layout.ColumnFitLayout.superclass.onLayout.apply(this, arguments);

        // get columns and height
        var cs = ct.items.items, len = cs.length, c, i;
        var size = Ext.isIE && target.dom != Ext.getBody().dom ? target.getStyleSize() : target.getViewSize();
        var h = size.height - target.getPadding('tb');

        // set height of columns
        for(i = 0; i < len; i++) {
            c = cs[i];
            c.setHeight(h + (c.footer ? c.footer.getHeight() : 0));
        }
    }
});

// register layout
Ext.Container.LAYOUTS['columnfit'] = Ext.ux.layout.ColumnFitLayout; 

// eof  