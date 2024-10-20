<?php 
$homepage_id = get_option('page_on_front');

// Retrieve custom fields from the WordPress database for links
$links = [
    'individuals'   => get_field('link_individuals', 'option'),
    'organisations' => get_field('link_organisations', 'option'),
    'researchers'   => get_field('link_researchers', 'option'),
    'healthcare'    => get_field('link_healthcare', 'option'),
    'industry'      => get_field('link_industry', 'option'),
    'founder'       => get_field('link_founder', 'option')
];
?>
<div class="container-fluid pb-5" id="infographic">
    <div class="container my-5">
        <div class="d-flex justify-content-center align-items-center container">
            <div class="manual-column-group">
                <div class="group community bg-secondary text-primary p-3 pt-4">
                    <?php if ( get_field('info_community_title', $homepage_id) ) : ?>
                        <strong><?php echo get_field('info_community_title', $homepage_id); ?></strong>
                    <?php endif; ?>
                    <?php if ( get_field('info_community_text', $homepage_id) ) : ?>
                        <?php echo get_field('info_community_text', $homepage_id); ?>
                    <?php endif; ?>
                </div>
                <div class="d-flex d-lg-none arrows flex-column justify-content-center text-primary py-3 w-100 text-center mobile-arrows">
                    <i class="bi bi-arrow-down-up"></i>
                </div>  
            </div>
            <div class="manual-column-center">
                <div class="center d-flex">
                    <div class="d-none d-lg-flex arrows flex-column justify-content-center text-primary px-3">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <div class="content-container text-center bg-primary text-white">
                        <div class="online-platform"><i class="bi bi-wifi"></i> RDRN PLATFORM</div>
                        <div class="content bg-white p-4 text-center d-flex align-items-center justify-content-center">
                            <img class="logo" alt="<?php echo get_option('blogname'); ?>" src="<?php echo get_field('header_logo','option')['url']; ?>" />
                            <?php if ( have_rows('patient_groups', $homepage_id) ) : $i=1; ?>
                                <?php while ( have_rows('patient_groups', $homepage_id) ) : the_row(); ?>
                                    <div class="group-content text-primary d-none" id="content-group<?php echo $i; ?>">
                                        <strong><?php echo get_sub_field('name', $homepage_id); ?></strong>
                                        <?php echo get_sub_field('description', $homepage_id); ?>
                                    </div>
                                    <?php $i++; endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="online-platform"><i class="bi bi-wifi"></i> RDRN PLATFORM</div>
                        <!-- Infographic images -->
                        <div class="infographic-images">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/infografic/RDRN Infographic_page<?php echo $i; ?>.jpg" alt="Infographic Page <?php echo $i; ?>" class="infographic-page" style="display: none;">
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="d-none d-lg-flex arrows flex-column justify-content-center text-primary px-3">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>                
                </div>
            </div>
            <div class="manual-column-icons">
                <div class="d-flex d-lg-none arrows flex-column justify-content-center text-primary py-3 w-100 text-center mobile-arrows">
                    <i class="bi bi-arrow-down-up"></i>
                </div>  
                <?php if ( have_rows('patient_groups', $homepage_id) ) : $i=1; ?>
                    <?php while ( have_rows('patient_groups', $homepage_id) ) : the_row(); ?>
                        <div class="svg-container" id="group<?php echo $i; ?>">
                            <?php $svg_code = file_get_contents(get_sub_field('icon', $homepage_id)['url']); ?>
                            <div class="svg-icon"><?php echo $svg_code; ?></div>
                        </div>
                        <?php $i++; endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function showPage(pageNumber) {
        var pages = document.querySelectorAll('.infographic-page');
        pages.forEach(page => page.style.display = 'none');
        document.getElementById('page' + pageNumber).style.display = 'block';
    }
    showPage(1);  // Initialize the first page

    document.getElementById('linkIndividuals').href = '<?php echo $links['individuals']; ?>';
    document.getElementById('linkOrganisations').href = '<?php echo $links['organisations']; ?>';
    document.getElementById('linkResearchers').href = '<?php echo $links['researchers']; ?>';
    document.getElementById('linkHealthcare').href = '<?php echo $links['healthcare']; ?>';
    document.getElementById('linkIndustry').href = '<?php echo $links['industry']; ?>';
    document.getElementById('linkFounder').href = '<?php echo $links['founder']; ?>';

    // Existing SVG interaction script
    var svgContainers = document.querySelectorAll('.svg-container');
    var logo = document.querySelector('.content .logo');
    svgContainers.forEach(function(container) {
        var groupId = container.id.replace('group', '');
        var contentBlock = document.getElementById('content-group' + groupId);
        container.addEventListener('mouseover', function() {
            contentBlock.classList.remove('d-none');
            logo.classList.add('d-none');
        });
        container.addEventListener('mouseout', function() {
            contentBlock.classList.add('d-none');
            logo.classList remove('d-none');
        });
    });
});
</script>
