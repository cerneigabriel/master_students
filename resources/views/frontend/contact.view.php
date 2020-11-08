<div class="container">
    <h1>Contact</h1>
    
    <form action="<?php echo url("contact.send"); ?>" method="post">
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea name="body" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>