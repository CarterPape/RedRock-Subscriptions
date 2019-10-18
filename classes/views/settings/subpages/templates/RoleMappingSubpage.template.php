<?php

die("incomplete implementation");

?>

<p>Assign roles to active (paying) and inactive (not paying) members. Memberful will automatically keep the role mappings in sync.</p>
<p>This functionality works best with custom roles created by other plugins.</p>

<form method="post" action="<?php echo admin_url('admin-post.php') ?>">
    <table
        id="memberful-role-mapping-table"
        class="
            widefat
            fixed
        "
    >
        <thead><tr>
            <th scope="col" class="manage-column">Map members with</th>
            <th scope="col" class="manage-column">to this role.</th>
        </tr></thead>
        <tbody class="role-mapping">
<?php
            foreach ($available_state_mappings as $state_id => $state) {
?>
                <tr>
                    <td class="customer-state">
                        <strong><?php echo $state['name']; ?></strong>
                    </td>
                    <td class="mapped-role">
                        <select name="role_mappings[<?php echo $state_id; ?>]">
<?php
                            foreach ($available_roles as $role => $role_name) {
?>
                                <option
                                    value="<?php echo $role; ?>"
<?php
                                    echo ($state['current_role'] === $role) ? 'selected="selected"' : '';
?>
                                >
                                    <?php echo $role_name; ?>
                                </option>
<?php
                            }
?>
                        </select>
                    </td>
                </tr>
<?php
            }
?>
        </tbody>
    </table>
    <input 
        type="submit"
        class="button button-primary left"
        value="save changes"
    >
    <?php $this->renderNonceField(); ?>
</form>
