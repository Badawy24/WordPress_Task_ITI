<?php
/* Template Name: Portfolio Page */
get_header();
?>

<style>
.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    padding: 40px;
    max-width: 1200px;
    margin: auto;
}
.project-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    background: #fff;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
}
.project-card:hover {
    transform: translateY(-5px);
}
.project-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.project-content {
    padding: 15px;
    flex-grow: 1;
}
.project-content h3 {
    margin: 10px 0;
    font-size: 1.2rem;
}
.project-content p {
    color: #555;
    font-size: 0.95rem;
    margin-bottom: 15px;
}
.project-content a {
    display: inline-block;
    padding: 8px 12px;
    background: #0073aa;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
}
.project-content a:hover {
    background: #005f8d;
}
</style>

<?php
$query = new WP_Query(['post_type' => 'projects', 'posts_per_page' => -1]);

if ($query->have_posts()) :
    echo '<div class="projects-grid">';
    while ($query->have_posts()) : $query->the_post();
        $tech = get_post_meta(get_the_ID(), '_pp_tech', true);
        $url = get_post_meta(get_the_ID(), '_pp_url', true);
        ?>
        <div class="project-card">
            <?php 
            if (has_post_thumbnail()) {
                echo get_the_post_thumbnail(get_the_ID(), 'large', ['style' => 'width:100%;height:200px;object-fit:cover;']);
            } else {
                echo '<img src="https://via.placeholder.com/600x200?text=No+Image" style="width:100%;height:200px;object-fit:cover;">';
            }
            ?>
            <div class="project-content">
                <h3><?php the_title(); ?></h3>
                <?php if ($tech) : ?>
                    <p>Technology Used: <?php echo esc_html($tech); ?></p>
                <?php endif; ?>
                <?php if ($url) : ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank">View Project</a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    endwhile;
    echo '</div>';
    wp_reset_postdata();
else :
    echo '<p style="text-align:center;">No projects found.</p>';
endif;

get_footer();
