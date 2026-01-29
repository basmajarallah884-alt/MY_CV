// Main JS
// Video Modal Logic (Global)
window.openModal = function (videoSrc) {
    const modal = document.getElementById('videoModal');
    const modalVideo = document.getElementById('modalVideo');
    if (videoSrc) {
        modal.style.display = 'flex';
        modalVideo.src = videoSrc;
        modalVideo.load(); // Correctly force load the new source
        modalVideo.play().catch(error => {
            console.log("Auto-play failed, user must press play manually:", error);
        });
    } else {
        console.error("No video source provided");
    }
}

document.addEventListener('DOMContentLoaded', () => {

    // Contact Form Handling (AJAX)
    const contactForm = document.querySelector('#contact form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = this.querySelector('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            btn.disabled = true;

            const formData = new FormData();
            formData.append('name', this.querySelector('input[type="text"]').value);
            formData.append('email', this.querySelector('input[type="email"]').value);
            formData.append('message', this.querySelector('textarea').value);

            fetch('submit_contact.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        btn.innerHTML = '<i class="fas fa-check"></i> Sent!';
                        btn.style.background = '#22c55e';
                        this.reset();
                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.style.background = '';
                            btn.disabled = false;
                        }, 3000);
                    } else {
                        alert(data.message);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong!');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        });
    }

    // Modal Close Logic
    const modal = document.getElementById('videoModal');
    const modalVideo = document.getElementById('modalVideo');
    const closeBtn = document.querySelector('.close-modal');

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            modalVideo.pause();
            modalVideo.src = "";
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target == modal) {
            modal.style.display = 'none';
            modalVideo.pause();
            modalVideo.src = "";
        }
    });

});
