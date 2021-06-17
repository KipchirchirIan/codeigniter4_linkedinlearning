<div>
  <div class="row column text-center">
    <h2>Welcome, <?php echo $user_name; ?></h2>
      <?php if (empty($selected_filter)): ?>
      <form action="<?php echo site_url('properties/set_filter'); ?>" method="get">
          <select name="filter">
              <?php foreach ($status_groups as $status): ?>
                  <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
              <?php endforeach; ?>
          </select>
          <input type="submit" value="Select" class="button warning">
      </form>
      <?php else: ?>
      <h4>Showing filter for: <?php echo $selected_filter; ?></h4>
      <?php endif; ?>
  </div>
</div>
<hr>

<div class="row column">
  <h3>Properties details</h3>
  <table border="0">
    <tr>
      <td>IMAGE</td>
      <td>NAME</td>
      <td>LOCATION</td>
      <td>STATUS</td>  
      <td>ACTION</td>  
    </tr>
      <?php foreach ($properties as $property): ?>
    <tr>
      <td><img src="<?php echo base_url("assets/images/{$property['image']}"); ?>" width="150" /></td>
      <td><?php echo $property['name']; ?> </td>
      <td><?php echo $property['city']; ?>, <?php echo $property['state']; ?> </td>
      <td>Available</td>
      <td>
        <a href="<?php echo site_url('properties/show/' . $property['id']); ?>" class="button success">View Details</a>
        <a href="<?php echo site_url('properties/edit/' . $property['id']); ?>" class="button">Edit Details</a>
      </td>  
    </tr>
      <?php endforeach; ?>
  </table>
  <br/>
</div>