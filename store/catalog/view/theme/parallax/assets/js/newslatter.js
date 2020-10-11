window.AdvancedNewsletter = function(params){
    this.init(params);
};

AdvancedNewsletter.prototype.init = function(params){
    var self = this;
    $(document).ready(function(){
        self.container_box      = $(params.container_id);
        self.input_email        = self.container_box.find(params.input_id);
        self.button_subbmit     = self.container_box.find(params.submit_id);
      //  console.log(self.container_box);
       // console.log(self.input_email);
       // console.log(self.button_subbmit);
        self.subscribe();

        if (typeof params.display_as != 'undefined'){
            self.container_box.subscribeBetter({
                animation: "flyInUp"
            });
        }
    });
}

AdvancedNewsletter.prototype.subscribe = function(){
    var self = this;
    this.button_subbmit.bind("click", function(){
        var selfClick = $(this);

        if(!self.input_email.val()){
            alert('Please enter your email!');
            return true;
        }

        selfClick.attr('disabled', true).addClass('disable');
        $.ajax({
            type:   "POST",
            url:    "index.php?route=extension/module/newsletter/index",
            data:   "email="+self.input_email.val(),
            dataType: 'json',
            success: function(data){
                alert(data.msg);
                selfClick.attr('disabled', false).removeClass('disable');
            },
           error: function(json){
        
      }
        });
    });
}



