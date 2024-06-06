<?php
$page_title = 'All Image';
require_once('includes/load.php');
page_require_level(2);
?>
<?php $media_files = find_all('media');?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-camera"></span>
        <span>All Photos</span>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th class="text-center">Photo</th>
              <th class="text-center">Photo Name</th>
              <th class="text-center" style="width: 20%;">Photo Type</th>
              <th class="text-center" style="width: 50px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($media_files as $media_file): ?>
              <tr class="list-inline">
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center">
                  <img src="uploads/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" />
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_name'];?>
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_type'];?>
                </td>
                <td class="text-center">
                  <a href="delete_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-xs"  title="Delete">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                  <!-- Adaugă butonul pentru trimiterea către "upload_drive.php" -->
                  <form action="upload_drive.php" method="POST">
      <input type="hidden" name="media_id" value="<?php echo (int) $media_file['id'];?>">
      <button type="submit" class="btn btn-primary btn-xs" name="upload_to_drive">Upload to Drive</button>
    </form>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
