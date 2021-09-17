<header_right>
    <div class="header_menu">

        <div id='cssmenu'>
            <ul>
                <li><a href='{$smarty.const.APPPATH}/home' target="_self"><span>HOME <img src="{$smarty.const.APPPATH}/img/icon_home.png" height=30px border="0" alt="keywords"/></span></a></li>

                {if $smarty.const.MEMBER_MANAGED}
                    {if $user == null}
                        <li>    
                            <a href="{$smarty.const.APPPATH}/login" target="_self">  
                             <span>SIGN IN <img src="{$smarty.const.APPPATH}/img/icon_login.png" height=30px border="0" alt="keywords"/></span>
                            </a>
                        </li>
                    {else}
                        <li class='has-sub'>
                          <a href="{$smarty.const.APPPATH}/mypage" target="_self">  
                            </span>{$user->getLast_name()} <img src="{$smarty.const.APPPATH}/img/icon_login.png" height=30px border="0" alt="keywords"/></span>
                          </a>
                          <ul>
                            <li><a href='{$smarty.const.APPPATH}/mypage' target="_self"><span>My Profile</span></a></li>                     
                            <li><a href="{$smarty.const.APPPATH}/login/logout" target="_self"><span>Sign out</span></a></li>            
                          </ul>            
                        </li>
                    {/if}
                {/if}

            </ul>
        </div>
  
        <div id='cssmenu_m'>
            <div id="cssmenu_mi">
                <a href='{$smarty.const.APPPATH}/home' target="_self"><span><img src="{$smarty.const.APPPATH}/img/icon_home.png" height=30px border="0" alt="keywords"/></span></a>
                <br> HOME
            </div>
            <div id="cssmenu_mi">
                {if $smarty.const.MEMBER_MANAGED}
                    {if $user == null}                
                        <a href='{$smarty.const.APPPATH}/login' target="_self"><span><img src="{$smarty.const.APPPATH}/img/icon_login.png" height=30px border="0" alt="keywords"/></span></a>   
                        <br>SIGN IN
                    {else}
                        <a href='{$smarty.const.APPPATH}/mypage' target="_self"><span><img src="{$smarty.const.APPPATH}/img/icon_login.png" height=30px border="0" alt="keywords"/></span></a>   
                        <br><span class="user_name">{$user->getLast_name()}</span>                     
                    {/if}  
                {/if}
            </div>

                
        </div>                
    </div>

</header_right>