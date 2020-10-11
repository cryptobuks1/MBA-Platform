<div  id="edit_lead_div">
    
   
        {form_open('','role="form" class="" method="post"  name="lead_register" id="edit_lead_form"')}
        <div class="col-md-12">
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i>
            </div>
        </div>

        <div class="form-group">
            <label class=" control-label" for="task">{lang("task")}<font color="#ff0000">*</font></label>
            
            
                <textarea name="task" id="input-task"   class="form-control textfixed" autocomplete="Off" size="500"  style="height: 100px;">{$task}</textarea>
                {form_error('task')}
            
        
        </div>
            

        <div class="form-group">
            <label>Date</label>
            
                <input  class="form-control date-picker" name="task_date" value="{$date}" id="input-task_date" type="text"  >
                {form_error('task_date')}
           </div>
           <div class="form-group input-append bootstrap-timepicker">
            <label for="start_time" >{lang("start_time")}</label>
            
            
                <input type="text" id="input-task_time" name="task_time" value="{$time}" title="Select TIME" class="form-control time-picker"  {* {if isset($party_setup_arr['timepicker1'])} value="{$party_setup_arr['timepicker1']}"{/if}*}/>                               
            </div>
        
      
            
        <div class="form-group">
         
                <p>
                    <input type="hidden" name="task_id" value="{$task_id}">
                    <button class="btn btn-primary" name="add_list" id="add_list" value="Update Lead" >
                        {lang("edit_list")}
                    </button>
                </p>
            
        </div>
        
        {form_close()}
    </div>


<script src="{$PUBLIC_URL}javascript/todo_config.js"></script>