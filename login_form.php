	<div id="errors" class="errors">ddgs</div>
        <form action="javascript:void(0);" method="POST" onSubmit="signin()">
        <table style="width:50%;margin-left:20%;">
        <tr><td><? echo $_LANG['Username']?>:</td>
        <td>&nbsp;</td>
        <td><input type="text" class="text" name="login" id="login"></td>
        </tr>
        <tr>
        <td><? echo $_LANG['Password']?>:</td>
        <td>&nbsp;</td>
        <td><input type="password" class="text" name="password" id="password"></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td colspan="3"><input type="submit" value="<? echo $_LANG['Sign_in']?>" name="submit" class="black_box"></td>
        </tr>
    
    </table></form>
