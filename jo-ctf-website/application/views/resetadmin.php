<div class="col-md-12 contwrap fullwin">
    <div class="col-md-offset-1 col-md-10 formarea">
        <h1>Reset Password</h1>
        <hr>
        <form class="col-md-offset-2 col-md-8" method="post" action="/Admin/resetPw/">
            <div class="form-group">
                <label for="exampleInputPassword1">Old Password</label>
                <input type="password" name="oldpw" class="form-control" id="exampleInputPassword1" placeholder="Old Password" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">New Password</label>
                <input type="password" name="pw" class="form-control" id="exampleInputPassword1" placeholder="New Password" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input type="password" name="cpw" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Login</button>
        </form>
    </div>
</div>