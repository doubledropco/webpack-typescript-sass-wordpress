<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform form-inline">
    <div class="form-group">
        <label class="sr-only" for="s">Search</label>
        <input type="text" class="form-control" id="s" name="s" placeholder="<?php echo esc_attr( 'Search...', 'presentation' ); ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?php _e('Search', 'wp-starter'); ?></button>  
</form>
