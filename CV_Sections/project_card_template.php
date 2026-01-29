                    <div class="project-card" style="background: var(--sidebar-bg); border: 1px solid var(--glass-border); border-radius: 16px; overflow: hidden; transition: 0.3s; position: relative; display: flex; flex-direction: column;">
                        <a href="<?php echo (!empty($p['video'])) ? 'javascript:void(0)' : htmlspecialchars($link); ?>" 
                           <?php if(empty($p['video']) && !empty($link)) echo 'target="_blank"'; ?>
                           <?php if(!empty($p['video'])) echo 'onclick="openModal(\''.base_url('uploads/'.$p['video']).'\')"'; ?>
                           class="project-media-link"
                           style="display: block; position: relative; height: 220px; overflow: hidden; background: #020617;">
                            
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
                            <h3 style="margin-bottom: 0.5rem; color: white; font-size: 1.25rem;"><?php echo htmlspecialchars($p['title']); ?></h3>
                            <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-bottom: 1rem; flex: 1; line-height: 1.6;"><?php echo htmlspecialchars(substr($p['description'] ?? '', 0, 120)) . '...'; ?></p>
                            
                             <div class="tech-tags" style="margin-bottom: 1.5rem; display: flex; gap: 8px; flex-wrap: wrap;">
                                <?php if (!empty($p['technologies'])): foreach(explode(',', $p['technologies']) as $tag): ?>
                                    <span style="background: rgba(255, 255, 255, 0.05); color: rgba(255,255,255,0.7); padding: 4px 10px; border-radius: 4px; font-size: 0.75rem;"><?php echo trim($tag); ?></span>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
