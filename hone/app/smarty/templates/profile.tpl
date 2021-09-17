<div class="boxWrapper">

    <div class ="boxAction">
        <span class="row">
            <span class="col-20"><label></label></span>
            <span class="col-80"><button type="submit" name="operation" value="profileUpdate" class="button big"><i class="fa fa-check"></i>更新する</button></span>
        </span>
    </div>   

    <div class="boxBody">    
        <span class="row">
            <span class="col-30 bold"><label>*: Required</label></span>
            <span class="col-70 bold red">{$message}</span>
        </span>
        <br> 
        <span class="row">
            <span class="col-30"><label> Last name *</label></span>
            <span class="col-70"><input type="text" name="last_name" placeholder="Hone" value="{if isset($user)}{$user->getLast_name()}{/if}" class="form-control" required></span>
        </span>

        <span class="row">
            <span class="col-30"><label> First name *</label></span>
            <span class="col-70"><input type="text" name="first_name" placeholder="John" value="{if isset($user)}{$user->getFirst_name()}{/if}" class="form-control" required></span>
        </span>

        <span class="row">
            <span class="col-30"><label> Phone</label></span>
            <span class="col-70"><input type="text" name="phone" placeholder="0901112222" value="{if isset($user)}{$user->getPhone()}{/if}" class="form-control phoneMasking" data-mask="000000000000000"></span>
        </span>

        <span class="row">
            <span class="col-30"><label>  Mail address *</label></span>
            <span class="col-70"><input type="text" name="pc_mail" placeholder="john.hone@domain.com" value="{if isset($user)}{$user->getPc_mail()}{/if}" class="form-control" required></span>
        </span>

        <div class ="row">
            <span class="col-30"></span>
            <span class="col-70 left-justify">
                <br>
                <input type="checkbox" name="accept_com" {if isset($user)}{if $user->getAccept_com()}checked="checked"{/if}{else}checked="checked"{/if}/>&emsp;I accept to receive some news ...
                <br>
            </span>
        </div>


    </div>
</div>    