<div class="wrap">
<h1>Contact Manager</h1>
<table class="wp-list-table widefat fixed striped">
<thead><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Address</th></tr></thead>
    <tbody>

    <?php foreach ($contacts as $contact) {?>
    <tr>
    <td> <?php echo $contact->id ?></td>
    <td> <?php echo $contact->email ?></td>
    <td> <?php echo $contact->first_name ?></td>
    <td> <?php echo $contact->last_name ?></td>
    <td> <?php echo $contact->phone_number ?></td>
    <td> <?php echo $contact->address ?></td>
    </tr>
    <?php }?>

    </tbody>
</table>
</div>