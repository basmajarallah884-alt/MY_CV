document.addEventListener('DOMContentLoaded', () => {
    const navBtns = document.querySelectorAll('.nav-btn');
    const sections = document.querySelectorAll('.section');
    const pageTitle = document.getElementById('page-title');
    const pageSubtitle = document.getElementById('page-subtitle');

    const titles = {
        'home': { title: 'Overview', subtitle: 'Welcome to my professional portfolio dashboard.' },
        'projects': { title: 'My Projects', subtitle: 'A collection of my recent work and case studies.' },
        'certificates': { title: 'Certificates', subtitle: 'Professional certifications and achievements.' },
        'contact': { title: 'Contact Me', subtitle: 'Let\'s get in touch and build something great.' }
    };

    navBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class
            navBtns.forEach(b => b.classList.remove('active'));
            sections.forEach(s => s.style.display = 'none');

            // Add active class
            btn.classList.add('active');
            const target = btn.getAttribute('data-target');
            const section = document.getElementById(target);

            // Show section with fade animation
            section.style.display = 'block';
            section.classList.remove('fade-in');
            void section.offsetWidth; // Trigger reflow
            section.classList.add('fade-in');

            // Update Header
            if (titles[target]) {
                pageTitle.textContent = titles[target].title;
                pageSubtitle.textContent = titles[target].subtitle;
            }
        });
    });
});
