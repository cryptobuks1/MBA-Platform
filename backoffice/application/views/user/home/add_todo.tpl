<div id="edit_lead_div" >
    
    
        {form_open('','role="form" class="" method="post"  name="lead_register" id="add_lead_form"')}
        
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i>
            </div>
    

        <div class="form-group">
            <label for="task">{lang("task")}</label>
            
           
                <textarea name="task" id="input-task"   class="form-control textfixed" autocomplete="Off" size="500"></textarea>
                {form_error('task')}
          
        
        </div>
            
       <div class="form-group ">
         
            <label>Date</label>
                <input  class="form-control date-picker" name="task_date" id="input-task_date" type="text"   >
                {form_error('task_date')}
            </div>
             
       
           <label for="task_time">{lang('start_time')}</label> 
            <div class=" form-group input-append bootstrap-timepicker" >
                 <input type="text" id="input-task_time" name="task_time" title="Select TIME" class="form-control time-picker"  {* {if isset($party_setup_arr['timepicker1'])} value="{$party_setup_arr['timepicker1']}"{/if}*}/> 
            </div>
            
        <div class="form-group">
          
                <p>
                {*    <input type="hidden" name="id" value="{$lead_details['id']}">*}
                    <button class="btn btn-primary btn-right" name="add_list" id="add_list" value="Update Lead" >
                        {lang("add_task")}
                    </button>
                </p>
            
        </div>
        
        {form_close()}
    
</div>

<script src="{$PUBLIC_URL}javascript/todo_config.js"></script>