<tr class="form-field term-group-wrap">
    <th scope="row">
        <label for="category-image-id">Category Image></label>
    </th>
     <td>
        <?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
        <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
        <div id="category-image-wrapper">
            <?php if ( $image_id ) { ?>
                <?php echo wp_get_attachment_image ( $image_id, 'category-image-thumb' ); ?>
            <?php } ?>
        </div>
        <p>
            <input type="button" class="button button-secondary ct_tax_media_button_category" id="ct_tax_media_button_category" name="ct_tax_media_button" value="Add Image" />
            <input type="button" class="button button-secondary ct_tax_media_remove_category" id="ct_tax_media_remove_category" name="ct_tax_media_remove" value="Remove Image" />
        </p>
        <p class="description">Used in the show category.</p>
     </td>
</tr>
