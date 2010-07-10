<div class="grid_8 prefix_2">
<div class="grid_7" style="border: #666 solid 1px; padding:30px;">
<form tal:attributes="action string:${application/site_root}/Dahius_Membership/login" method="POST" action="self">
    <h6 style="border-bottom:1px solid #999;">Login Form</h6>
    <div>
        <label tal:content="application/i18n/email">Email:</label>
        <input type="textbox" name="email" id="email"/>
    </div>
    <div>
        <label>Password:</label>
        <input type="password" name="password" id="password"/>
    </div>
    <div>
        <label>
            <input type="checkbox" name="persistent" checked="true" />
            <span>Keep me logged user</span>
        </label>
    </div>

    <div>
        <input type="submit" value="Login"/>
    </div>
</form>
</div>
</div>
