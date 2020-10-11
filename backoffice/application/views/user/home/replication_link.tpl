 {extends file=$BASE_TEMPLATE}



{block name=$CONTENT_BLOCK}

<div class="col-xs-12">
                        <div class="panel item">
                            <div class="panel-body">
                                
                             <div class="clear pull-left">
                                
                                 <input type="text" id="copyTarget" value="{$site_url}/replica/{$LOG_USER_NAME}"  readonly style="width: 500px;">
                                    <button id="copyButton"  class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"> 
                                    <i class="fa fa-copy text-info"></i>{lang('copy_link')}
                                    </button>
                             </div>
                        </div>
                    </div>
{/block}

{block name=script}
     {$smarty.block.parent}
     
          <script>
           document.getElementById("copyButton").addEventListener("click", function() {
             copyToClipboard(document.getElementById("copyTarget"));
            });

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        
        target = elem; 
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
          </script>
        
{/block}