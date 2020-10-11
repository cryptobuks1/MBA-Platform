
    <div class="btn-toolbar m-b-sm btn-editor" data-role="editor-toolbar" data-target="#editor">
        
        <div class="btn-group dropdown" dropdown>
            <a class="btn btn-default" data-toggle="dropdown" title="" data-original-title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li>
                    <li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li>
                    <li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li>
                    <li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li>
                    <li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li>      
                    <li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li>
                </ul>
        </div>
    
        <div class="btn-group dropdown" dropdown>
            <a class="btn btn-default" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                    <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                    <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                </ul>
        </div>    
        
        <div class="btn-group">
            <a class="btn btn-default" data-edit="bold" tooltip="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
            <a class="btn btn-default" data-edit="italic" tooltip="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
            <a class="btn btn-default" data-edit="strikethrough" tooltip="Strikethrough"><i class="fa fa-strikethrough"></i></a>
            <a class="btn btn-default" data-edit="underline" tooltip="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
        </div>
        
        <div class="btn-group">
            <a class="btn btn-default" data-edit="insertunorderedlist" tooltip="Bullet list"><i class="fa fa-list-ul"></i></a>
            <a class="btn btn-default" data-edit="insertorderedlist" tooltip="Number list"><i class="fa fa-list-ol"></i></a>
            <a class="btn btn-default" data-edit="outdent" tooltip="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
            <a class="btn btn-default" data-edit="indent" tooltip="Indent (Tab)"><i class="fa fa-indent"></i></a>
        </div>
        
        <div class="btn-group">
            <a class="btn btn-default" data-edit="justifyleft" tooltip="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
            <a class="btn btn-default" data-edit="justifycenter" tooltip="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
            <a class="btn btn-default" data-edit="justifyright" tooltip="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
            <a class="btn btn-default" data-edit="justifyfull" tooltip="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
        </div>

{*        <div class="btn-group dropdown" dropdown>
            <a class="btn btn-default" dropdown-toggle tooltip="Hyperlink"><i class="fa fa-link"></i></a>
            <div class="dropdown-menu">
                <div class="input-group m-l-xs m-r-xs">
                    <input class="form-control input-sm" id="LinkInput" placeholder="URL" type="text" data-edit="createLink"/>
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Add</button>
                    </div>
                </div>
            </div>
            <a class="btn btn-default" data-edit="unlink" tooltip="Remove Hyperlink"><i class="fa fa-cut"></i></a>
        </div>*}
              
        <div class="btn-group">
              <a class="btn btn-default" tooltip="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
              <input type="file" data-edit="insertImage" style="position:absolute; opacity:0; width:41px; height:34px" />
        </div>
        
        <div class="btn-group">
            <a class="btn btn-default" data-edit="undo" tooltip="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
            <a class="btn btn-default" data-edit="redo" tooltip="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
        </div>
        
    </div>
    <div ui-jq="wysiwyg" type="text" class="form-control text_area_width wysiwyg"  name="message" id="message" contenteditable="true">
    </div>
{*        <input type="hid  den" id="message" name="message" />*}