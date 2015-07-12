{{ content() }}

<?php echo $this->tag->form(array("user/search", "autocomplete" => "off")) ?>

<div align="center">
    <h1>Search user</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="id">Id</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("id", "type" => "number")) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="name">Name</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("name", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="email">Email</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("email", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="role">Role</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("role", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="phone">Phone</label>
        </td>
        <td align="left">
                <?php echo $this->tag->textArea(array("phone", "cols" => 30, "rows" => 4)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="crypt_hash">Crypt Of Hash</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("crypt_hash", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="picture">Picture</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("picture", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="password_salt">Password Of Salt</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("password_salt", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="active">Active</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("active", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="forgot_password_hash">Forgot Of Password Of Hash</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("forgot_password_hash", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="created_at">Created</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("created_at", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="updated_at">Updated</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("updated_at", "size" => 30)) ?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td><?php echo $this->tag->submitButton("Search") ?></td>
    </tr>
</table>

</form>
