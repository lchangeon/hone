    <div class="login_box_top">
        Password reset
    </div>
    
    <div class="login_box_middle_outer">
        <div class="login_box_middle_inner">
            <input type="hidden" name="pc_mail" value="{$pc_mail}"/>
            <label for="pc_mail_display" class="left-justify">Mail address</label>
            <input type="text" id="pc_mail_display" class="form-control" name="pc_mail_display" value="{$pc_mail}" disabled="disabled"/>

            <span class="row">
                <span class="col-50">
                    <label for="password1" class="left-justify">Password</label>
                    <input type="password" id="password1" class="form-control" name="password1" placeholder="Password" required/>
                 </span>
                <span class="col-50">
                    <label for="password2" class="left-justify">Password confirmation</label>
                    <input type="password" id="password2" class="form-control" name="password2" placeholder="Password confirmation" required/>                    
                </span>
            </span>
            
            <div class="login_message">
                {$message}
            </div>           
        </div> 
    </div> 
            
    <div class="login_box_bottom">
        <button type="submit" class="button big" name="operation" value="reset">RESET and SIGN IN</button>
    </div>      