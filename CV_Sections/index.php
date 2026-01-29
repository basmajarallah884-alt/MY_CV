<?php
require_once '../dashboard_CV/config.php';

// Fetch Profile
$profile = $conn->query("SELECT * FROM profile LIMIT 1")->fetch_assoc();
$settings_res = $conn->query("SELECT * FROM settings");
$settings = [];
while ($row = $settings_res->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=1.2">
</head>
<body>

    <!-- Wavy Background -->
    <div class="wave-container">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(6, 182, 212, 0.15)" /> 
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(6, 182, 212, 0.1)" /> 
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(6, 182, 212, 0.05)" /> 
            </g>
        </svg>
    </div>

    <div class="main-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <img src="<?php echo base_url('uploads/' . ($settings['profile_img'] ?? 'default_profile.jpg')); ?>" alt="Logo" class="logo-img">
                <h2>MY<span class="purple-text">PORTFOLIO</span></h2>
            </div>
            <ul class="nav-links">
                <li class="active"><a href="#home"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="#about"><i class="fas fa-user-assistant"></i> About Me</a></li>
                <li><a href="#projects"><i class="fas fa-laptop-code"></i> Projects</a></li>
                <li><a href="#certificates"><i class="fas fa-award"></i> Certificates</a></li>
                <li><a href="#contact"><i class="fas fa-paper-plane"></i> Contact</a></li>
            </ul>

            <!-- Social Icons at Sidebar Bottom -->
            <div class="sidebar-footer" style="margin-top: auto; padding-top: 2rem; border-top: 1px solid var(--glass-border);">
                <div class="social-icons" style="display: flex; gap: 10px; justify-content: center;">
                    <?php
                    $socials_side = $conn->query("SELECT * FROM socials");
                    if($socials_side->num_rows > 0):
                        while($soc = $socials_side->fetch_assoc()):
                    ?>
                    <a href="<?php echo htmlspecialchars($soc['url']); ?>" target="_blank" style="text-decoration: none; color: rgba(255,255,255,0.6); transition: 0.3s; font-size: 1.1rem; width: 35px; height: 35px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; border-radius: 50%;"><i class="<?php echo htmlspecialchars($soc['icon_class']); ?>"></i></a>
                    <?php endwhile; endif; ?>
                </div>
                <p style="font-size: 0.7rem; color: rgba(255,255,255,0.3); text-align: center; margin-top: 15px;">&copy; <?php echo date('Y'); ?> MYPORTFOLIO</p>
            </div>
        </nav>

        <!-- Content -->
        <!-- Content -->
        <main class="content">
            <!-- Home Section -->
            <section id="home" class="fade-in active">
                <div class="hero-content">
                    <h5 class="subtitle"><?php echo htmlspecialchars($settings['hero_title'] ?? 'WELCOME'); ?></h5>
                    <div class="profile-box">
                       <!-- Profile Image is fetched from DB -->
                       <img src="<?php echo base_url('uploads/' . ($settings['profile_img'] ?? 'default_profile.jpg')); ?>" alt="Profile" class="profile-img">
                    </div>
                    <h1 class="title">Hi, I'm <span class="purple-text"><?php echo htmlspecialchars($profile['full_name']); ?></span></h1>
                    <h3 class="job-title">
                        <?php echo htmlspecialchars($profile['job_title']); ?> 
                        <?php if(!empty($profile['age'])) echo '<span style="font-size: 0.8em; opacity: 0.7;">• ' . $profile['age'] . ' Years Old</span>'; ?>
                    </h3>
                    <p class="description">
                        <?php echo htmlspecialchars($settings['hero_subtitle'] ?? 'Creating beautiful digital experiences through clean code and modern design.'); ?>
                    </p>
                    <div class="hero-btns">
                        <a href="#contact" class="btn btn-primary">Hire Me</a>
                        <a href="#projects" class="btn btn-outline">My Projects</a>
                    </div>
                </div>
            </section>

             <!-- About Section -->
             <section id="about" style="display:none; padding-top: 1rem;" class="fade-in">
                <h5 class="subtitle">WHO AM I?</h5>
                <h2 class="title" style="font-size: 2.5rem; margin-bottom: 2rem;">About <span class="purple-text">Me</span></h2>
                <div class="about-grid">
                    <div>
                        <p class="description" style="font-size: 1.05rem;">
                            <?php echo nl2br(htmlspecialchars($settings['about_text'] ?? "I'm a passionate Full Stack Developer based in Yemen. I enjoy turning complex problems into simple, beautiful and intuitive designs. \n\nMy job is to build your website so that it is functional and user-friendly but at the same time attractive.")); ?>
                        </p>
                        <div class="about-stats">
                            <?php
                            $st_res = $conn->query("SELECT * FROM stats ORDER BY ordering ASC");
                            if($st_res->num_rows > 0):
                                while($st = $st_res->fetch_assoc()):
                            ?>
                            <div class="stat-box">
                                <i class="<?php echo htmlspecialchars($st['icon']); ?>" style="font-size: 1.5rem; color: var(--purple-primary); margin-bottom: 0.5rem; display: block;"></i>
                                <h3 style="margin: 0; font-size: 2rem;"><?php echo htmlspecialchars($st['number']); ?></h3>
                                <p style="margin: 0; font-size: 0.8rem; line-height: 1.2;"><?php echo htmlspecialchars($st['label']); ?></p>
                            </div>
                            <?php endwhile; endif; ?>
                        </div>
                        <div class="social-links" style="margin-top: 3rem;">
                            <?php
                            $socials = $conn->query("SELECT * FROM socials");
                            if($socials->num_rows > 0):
                                $socials->data_seek(0); // Reset pointer for reuse
                                while($soc = $socials->fetch_assoc()):
                            ?>
                            <a href="<?php echo htmlspecialchars($soc['url']); ?>" target="_blank" class="social-btn">
                                <i class="<?php echo htmlspecialchars($soc['icon_class']); ?>"></i>
                            </a>
                            <?php endwhile; endif; ?>
                        </div>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.03); padding: 2rem; border-radius: 15px; border: 1px solid var(--glass-border);">
                        <h4 class="mb-4 text-white" style="font-size: 1.2rem; margin-bottom: 1.5rem;">Relevant Coursework</h4>
                        <div class="tags" style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <?php 
                            $skills = $conn->query("SELECT * FROM skills");
                            if($skills->num_rows > 0) {
                                while($s = $skills->fetch_assoc()) {
                                    echo '<span style="background: rgba(6, 182, 212, 0.1); color: #22d3ee; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; border: 1px solid rgba(6, 182, 212, 0.2);">'.$s['skill_name'].'</span>';
                                }
                            } else {
                                echo '<span style="color: grey">No skills added yet.</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Projects Section -->
            <section id="projects" style="display:none; padding-top: 2rem;" class="fade-in">
                 <h5 class="subtitle">PORTFOLIO</h5>
                <h2 class="title" style="font-size: 2.5rem;">Recent <span class="purple-text">Work</span></h2>
                <div class="projects-grid">
                    <?php
                    $projs = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
                    while($p = $projs->fetch_assoc()):
                        // Fix Link Logic
                        $link = $p['link'];
                        if(strpos($link, '/institute') !== false && strpos($link, 'http') === false) {
                             $link = 'http://localhost' . $link;
                        } elseif (strpos($link, 'http') === false && !empty($link)) {
                            $link = 'http://' . $link;
                        }
                    ?>
                    <div class="project-card" style="background: var(--sidebar-bg); border: 1px solid var(--glass-border); border-radius: 16px; overflow: hidden; transition: 0.3s; position: relative; display: flex; flex-direction: column;">
                        
                        <!-- Clickable Media Area -->
                        <a href="<?php echo (!empty($p['video'])) ? 'javascript:void(0)' : htmlspecialchars($link); ?>" 
                           <?php if(empty($p['video']) && !empty($link)) echo 'target="_blank"'; ?>
                           <?php if(!empty($p['video'])) echo 'onclick="openModal(\''.base_url('uploads/'.$p['video']).'\'); return false;"'; ?>
                           class="project-media-link"
                           style="display: block; position: relative; height: 220px; overflow: hidden; background: #020617; cursor: pointer;">
                            
                            <?php 
                            $img_path = 'uploads/'.$p['image'];
                            $has_image = !empty($p['image']) && file_exists('../dashboard_CV/'.$img_path);
                            
                            if($has_image): ?>
                                <img src="<?php echo base_url($img_path); ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85; transition: 0.3s;">
                            <?php else: ?>
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--purple-primary); font-size: 4rem;"><i class="fas fa-laptop-code"></i></div>
                            <?php endif; ?>
                            
                            <?php if(!empty($p['video'])): ?>
                                <div class="play-icon" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.4);">
                                    <i class="fas fa-play-circle" style="color: white; font-size: 4rem; text-shadow: 0 0 20px rgba(0,0,0,0.5);"></i>
                                </div>
                            <?php endif; ?>
                        </a>

                        <div class="p-4" style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                            <h3 style="margin-bottom: 0.5rem; color: white; font-size: 1.25rem;">
                                <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" style="text-decoration: none; color: white;"><?php echo htmlspecialchars($p['title']); ?></a>
                            </h3>
                            <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-bottom: 1rem; flex: 1; line-height: 1.6;"><?php echo htmlspecialchars(substr($p['description'] ?? '', 0, 120)) . '...'; ?></p>
                            
                             <div class="tech-tags" style="margin-bottom: 1.5rem; display: flex; gap: 8px; flex-wrap: wrap;">
                                <?php if (!empty($p['technologies'])): foreach(explode(',', $p['technologies']) as $tag): ?>
                                    <span style="background: rgba(255, 255, 255, 0.05); color: rgba(255,255,255,0.7); padding: 4px 10px; border-radius: 4px; font-size: 0.75rem;"><?php echo trim($tag); ?></span>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

             <!-- Video Modal -->
             <div id="videoModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); align-items: center; justify-content: center;">
                <span class="close-modal" style="position: absolute; top: 20px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
                <video class="modal-content" id="modalVideo" controls style="max-width: 90%; max-height: 90vh; border-radius: 10px; box-shadow: 0 0 50px rgba(6, 182, 212, 0.5);">
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

             <!-- Certificates Section -->
             <section id="certificates" style="display:none; padding-top: 2rem;" class="fade-in">
                <h5 class="subtitle">CREDENTIALS</h5>
                <h2 class="title" style="font-size: 2.5rem;">My <span class="purple-text">Certificates</span></h2>
                <div class="cert-grid">
                    <?php
                    $certs = $conn->query("SELECT * FROM certificates ORDER BY created_at DESC");
                    if ($certs->num_rows > 0):
                        while($c = $certs->fetch_assoc()):
                    ?>
                    <div class="cert-card" style="background: var(--sidebar-bg); border-radius: 12px; overflow: hidden; border: 1px solid var(--glass-border); transition: 0.3s;">
                        <div style="height: 200px; overflow: hidden; background: #0f172a; display: flex; align-items: center; justify-content: center;">
                            <?php 
                            $c_img_path = 'uploads/'.$c['image'];
                            if(!empty($c['image']) && file_exists('../dashboard_CV/'.$c_img_path)): ?>
                                <img src="<?php echo base_url($c_img_path); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fas fa-award fa-4x" style="color: rgba(255,255,255,0.1);"></i>
                            <?php endif; ?>
                        </div>
                        <div style="padding: 1.5rem;">
                            <h4 style="color: white; font-size: 1.1rem; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($c['title']); ?></h4>
                            <p style="color: var(--purple-primary); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($c['issuer']); ?></p>
                            <small style="color: rgba(255,255,255,0.4);"><?php echo $c['issue_date'] ? date('M Y', strtotime($c['issue_date'])) : ''; ?></small>
                        </div>
                    </div>
                    <?php endwhile; 
                    else: ?>
                        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: rgba(255,255,255,0.02); border-radius: 15px;">
                            <p class="text-muted">No certificates uploaded yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
            
            <!-- Contact Section -->
             <section id="contact" style="display:none; padding-top: 1rem;" class="fade-in">
                <h5 class="subtitle">GET IN TOUCH</h5>
                <h2 class="title" style="font-size: 2.5rem; margin-bottom: 3rem;">Contact <span class="purple-text">Me</span></h2>
                <div class="about-grid" style="align-items: center;">
                    <div>
                        <h3 style="color: white; font-size: 2rem; margin-bottom: 1rem;"><?php echo htmlspecialchars($settings['contact_title'] ?? "Let's work together!"); ?></h3>
                        <p class="description">
                            <?php echo nl2br(htmlspecialchars($settings['contact_text'] ?? 'I am available for freelance projects...')); ?>
                        </p>
                        
                        <div style="margin-top: 2rem;">
                             <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                                <div style="width: 50px; height: 50px; background: rgba(6, 182, 212, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--purple-primary); font-size: 1.2rem;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h5 style="color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 2px;">Email</h5>
                                    <h4 style="color: white; font-size: 1.1rem;"><?php echo htmlspecialchars($profile['email']); ?></h4>
                                </div>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                                <div style="width: 50px; height: 50px; background: rgba(6, 182, 212, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--purple-primary); font-size: 1.2rem;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h5 style="color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 2px;">Phone</h5>
                                    <h4 style="color: white; font-size: 1.1rem;"><?php echo htmlspecialchars($profile['phone']); ?></h4>
                                </div>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 50px; height: 50px; background: rgba(6, 182, 212, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--purple-primary); font-size: 1.2rem;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h5 style="color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 2px;">Location</h5>
                                    <h4 style="color: white; font-size: 1.1rem;"><?php echo htmlspecialchars($profile['location']); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form style="background: var(--sidebar-bg); padding: 2.5rem; border-radius: 16px; border: 1px solid var(--glass-border); box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                        <div style="margin-bottom: 1.5rem;">
                            <input type="text" placeholder="Your Name" style="width: 100%; padding: 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 8px; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='var(--purple-primary)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                        </div>
                         <div style="margin-bottom: 1.5rem;">
                            <input type="email" placeholder="Your Email" style="width: 100%; padding: 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 8px; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='var(--purple-primary)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                        </div>
                         <div style="margin-bottom: 1.5rem;">
                            <textarea rows="4" placeholder="Message" style="width: 100%; padding: 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 8px; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='var(--purple-primary)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'"></textarea>
                        </div>
                        <button class="btn btn-primary" style="width: 100%; cursor: pointer; font-size: 1rem; padding: 15px;">Send Message <i class="fas fa-paper-plane ml-2"></i></button>
                    </form>
                </div>
            </section>
            
        </main>
    </div>

    <script src="assets/js/main.js?v=<?php echo time(); ?>"></script>
    <script>
        // Simple client-side routing
        document.querySelectorAll('.nav-links a, .hero-btns a').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if(!href.startsWith('#')) return; // Allow normal links
                
                e.preventDefault();
                const targetId = href.substring(1);
                
                // Hide all sections explicitly
                document.querySelectorAll('main.content section').forEach(sec => {
                    sec.style.display = 'none';
                    sec.classList.remove('active');
                    sec.classList.remove('fade-in');
                });

                // Show target
                const targetSec = document.getElementById(targetId);
                if(targetSec) {
                    targetSec.style.display = 'block';
                    targetSec.classList.add('active');
                    // Force reflow for animation if needed, or just add class
                    setTimeout(() => targetSec.classList.add('fade-in'), 10);
                }
                
                // Active link update in sidebar
                document.querySelectorAll('.nav-links li').forEach(li => li.classList.remove('active'));
                const sidebarLink = document.querySelector(`.nav-links a[href="#${targetId}"]`);
                if(sidebarLink) sidebarLink.parentElement.classList.add('active');
            });
        });
    </script>
</body>
</html>
