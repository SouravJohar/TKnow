<div class="col-md-12 contwrap">
<div class="col-md-offset-1 col-md-10 contarea fullart">
    <h1><?php echo $post['title']; ?></h1>
    <h3><?php echo $post['author'];?></h3>
    <h5><?php echo $post['data']; ?></h5>
    <hr>
    <p><?php echo nl2br($post['content']); ?></p>
    <div class="col-md-6">
        <a class="btn btn-danger" href="/admin/decline/?id=<?php echo $post['id']; ?>">Decline</a>
    </div>
    <div class="col-md-6">
        <form method="post" action="/admin/approval" enctype="multipart/form-data">
            <div class="form-group col-md-6" style="overflow: hidden">
                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                <input type="file" name="post_img" id="exampleInputFile">
            </div>
            <button type="submit" class="btn btn-success">Approve</button>
        </form>
    </div>
</div>
</div>