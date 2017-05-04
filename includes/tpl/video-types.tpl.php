<style>
    .inside ul li ul {
        margin-left:15px;
    }
</style>
<ul>
<?php foreach($types as $type): ?>
<?php $children = get_categories(array('child_of' => $type->term_id, 'hide_empty' => 0)); ?>
    <li>
    <?php if($children > 0): ?>
        <?php
            /*
                If the category has child ('count'),
                    display it in a list.
            */
        ?>
            <label title="<?php esc_attr_e( $type->name); ?>">
                <input
                    type="radio"
                    name="video_category"
                    value="<?php esc_attr_e( $type->name ); ?>"
                    <?php checked( $type->name, $name ); ?>
                />
                <span><?php esc_html_e( $type->name ); ?></span>
            </label>
            <ul>
            <?php
                $inner_types = get_terms(
                'video_category',
                    array(
                        'hide_empty' => false,
                        'parent' => $type->term_id
                    )
                );
                foreach($inner_types as $itype):
            ?>
                    <li>
                        <label title="<?php esc_attr_e( $itype-> name); ?>">
                            <input
                                type="radio"
                                name="video_category"
                                value="<?php esc_attr_e( $itype->name ); ?>"
                                <?php checked( $itype->name, $name ); ?>
                            />
                            <span><?php esc_html_e( $itype->name ); ?></span>
                        </label>
                    </li>
                <?php endforeach; ?>
        </ul>
        <?php else: ?>
            <label title="<?php esc_attr_e( $type-> name); ?>">
                <input
                    type="radio"
                    name="video_category"
                    value="<?php esc_attr_e( $type->name ); ?>"
                    <?php checked( $type->name, $name ); ?>
                />
                <span><?php esc_html_e( $type->name ); ?></span>
            </label>
    <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
