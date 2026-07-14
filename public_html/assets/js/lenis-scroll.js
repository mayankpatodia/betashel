/**
 * Lenis Smooth Scrolling & Modern Scroll Animations
 * Inspired by comet.perplexity.ai
 * 
 * Features:
 * - Smooth scrolling with Lenis JS
 * - Fade-in animations for sections
 * - Subtle parallax effects
 * - Scale and translate transforms
 * - Stagger animations for lists
 */

class ModernScrollExperience {
    constructor() {
        this.lenis = null;
        this.isInitialized = false;
        this.scrollElements = new Map();
        this.init();
    }

    /**
     * Initialize Lenis and all scroll animations
     */
    init() {
        this.initLenis();
        this.setupScrollAnimations();
        this.bindEvents();
        this.isInitialized = true;
        console.log('🎯 Modern scroll experience initialized');
    }

    /**
     * Initialize Lenis Smooth Scrolling
     */
    initLenis() {
        // Destroy any existing scroll instances
        if (window.lenis) {
            window.lenis.destroy();
        }

        // Initialize Lenis with optimized settings
        this.lenis = new Lenis({
            duration: 1.2,           // Scroll duration
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Custom easing
            direction: 'vertical',   // Scroll direction
            gestureDirection: 'vertical',
            smooth: true,
            mouseMultiplier: 1,      // Mouse wheel sensitivity
            smoothTouch: false,      // Disable on touch devices for better performance
            touchMultiplier: 2,      // Touch sensitivity
            infinite: false,         // No infinite scroll
        });

        // Store globally for potential external access
        window.lenis = this.lenis;

        // Start the animation loop
        this.startRafLoop();

        // Update ScrollTrigger with Lenis
        if (window.ScrollTrigger && typeof window.ScrollTrigger.scrollerProxy === 'function') {
            try {
                this.lenis.on('scroll', ScrollTrigger.update);
                
                // Store reference to lenis instance for scrollerProxy
                const lenisInstance = this.lenis;
                
                ScrollTrigger.scrollerProxy(document.body, {
                    scrollTop(value) {
                        if (arguments.length) {
                            lenisInstance.scrollTo(value, { duration: 0, immediate: true });
                            return value;
                        }
                        return lenisInstance.animatedScroll || 0;
                    },
                    getBoundingClientRect() {
                        return { top: 0, left: 0, width: window.innerWidth, height: window.innerHeight };
                    },
                    pinType: document.body.style.transform ? "transform" : "fixed"
                });
                
                console.log('✅ ScrollTrigger scrollerProxy configured for Lenis');
            } catch (error) {
                console.warn('⚠️ Could not configure ScrollTrigger scrollerProxy:', error);
            }
        } else {
            console.warn('⚠️ ScrollTrigger not available or scrollerProxy method missing');
        }
    }

    /**
     * Start the requestAnimationFrame loop for Lenis
     */
    startRafLoop() {
        const raf = (time) => {
            this.lenis.raf(time);
            requestAnimationFrame(raf);
        };
        requestAnimationFrame(raf);
    }

    /**
     * Setup all scroll-driven animations
     */
    setupScrollAnimations() {
        if (!window.ScrollTrigger) {
            console.warn('⚠️ ScrollTrigger not available - skipping scroll animations');
            return;
        }

        const animations = [
            { name: 'Fade-in', method: () => this.setupFadeInAnimations() },
            { name: 'Parallax', method: () => this.setupParallaxEffects() },
            { name: 'Scale', method: () => this.setupScaleAnimations() },
            { name: 'Stagger', method: () => this.setupStaggerAnimations() },
            { name: 'Counter', method: () => this.setupCounterAnimations() },
            { name: 'Hero', method: () => this.setupHeroAnimations() },
            { name: 'Portfolio', method: () => this.setupPortfolioAnimations() }
        ];

        animations.forEach(({ name, method }) => {
            try {
                method();
                console.log(`✅ ${name} animations initialized`);
            } catch (error) {
                console.warn(`⚠️ Failed to initialize ${name} animations:`, error);
            }
        });
    }

    /**
     * Fade-in animations for sections as they enter viewport
     * Inspired by comet.perplexity.ai's subtle element reveals
     */
    setupFadeInAnimations() {
        const fadeElements = [
            '.legal-section',
            '.rts-service-area',
            '.our-approch-area-style-one',
            '.rts-pricing-area',
            '.counter-area-elements',
            '.rts-footer-area-one',
            '.service-area-one-main-wrapper .single-item-service-one',
            '.single-approach-area-start',
            '.pricing-tabs-homepage'
        ];

        fadeElements.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach((element, index) => {
                // Set initial state
                gsap.set(element, {
                    opacity: 0,
                    y: 30,
                    scale: 0.98
                });

                // Create scroll trigger
                ScrollTrigger.create({
                    trigger: element,
                    start: "top 85%",
                    end: "bottom 15%",
                    onEnter: () => {
                        gsap.to(element, {
                            opacity: 1,
                            y: 0,
                            scale: 1,
                            duration: 0.8,
                            delay: index * 0.1,
                            ease: "power2.out"
                        });
                    },
                    onLeave: () => {
                        gsap.to(element, {
                            opacity: 0.3,
                            duration: 0.3,
                            ease: "power2.out"
                        });
                    },
                    onEnterBack: () => {
                        gsap.to(element, {
                            opacity: 1,
                            duration: 0.5,
                            ease: "power2.out"
                        });
                    }
                });
            });
        });
    }

    /**
     * Subtle parallax effects for background elements
     */
    setupParallaxEffects() {
        const parallaxElements = [
            { selector: '.banner-area', speed: 0.5 },
            { selector: '.legal-hero', speed: 0.3 },
            { selector: '.bg-dark-1', speed: 0.2 }
        ];

        parallaxElements.forEach(({ selector, speed }) => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                gsap.to(element, {
                    yPercent: -50 * speed,
                    ease: "none",
                    scrollTrigger: {
                        trigger: element,
                        start: "top bottom",
                        end: "bottom top",
                        scrub: true
                    }
                });
            });
        });
    }

    /**
     * Scale animations for interactive elements
     */
    setupScaleAnimations() {
        const scaleElements = [
            '.title.rts_hero__title',
            '.error-number',
            '.logo img',
            '.rts-btn-mouse-move'
        ];

        scaleElements.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                gsap.set(element, { scale: 0.9, opacity: 0 });

                ScrollTrigger.create({
                    trigger: element,
                    start: "top 90%",
                    onEnter: () => {
                        gsap.to(element, {
                            scale: 1,
                            opacity: 1,
                            duration: 1,
                            ease: "back.out(1.7)"
                        });
                    }
                });
            });
        });
    }

    /**
     * Stagger animations for lists and grid items
     */
    setupStaggerAnimations() {
        const staggerGroups = [
            '.navbar-nav-1 li',
            '.footer-nav li',
            '.rts-social-area-one ul li',
            '.legal-nav-list li',
            '.request-issues li',
            '.permission-list li'
        ];

        staggerGroups.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            if (elements.length > 0) {
                gsap.set(elements, { opacity: 0, x: -20 });

                ScrollTrigger.create({
                    trigger: elements[0].closest('ul, nav, .legal-nav, .request-info, .permission-details'),
                    start: "top 80%",
                    onEnter: () => {
                        gsap.to(elements, {
                            opacity: 1,
                            x: 0,
                            duration: 0.6,
                            stagger: 0.1,
                            ease: "power2.out"
                        });
                    }
                });
            }
        });
    }

    /**
     * Animated counters with scroll trigger
     */
    setupCounterAnimations() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            gsap.set(counter, { textContent: 0 });

            ScrollTrigger.create({
                trigger: counter,
                start: "top 80%",
                onEnter: () => {
                    gsap.to(counter, {
                        textContent: target,
                        duration: 2,
                        ease: "power2.out",
                        snap: { textContent: 1 },
                        onUpdate: function() {
                            counter.textContent = Math.ceil(counter.textContent);
                        }
                    });
                }
            });
        });
    }

    /**
     * Hero section animations with sophisticated timing
     */
    setupHeroAnimations() {
        const heroElements = {
            title: '.title.rts_hero__title',
            subtitle: '.hero__sub-title',
            button: '.banner-jump-button',
            image: '.banner-area .shape-image'
        };

        Object.entries(heroElements).forEach(([key, selector], index) => {
            const element = document.querySelector(selector);
            if (element) {
                gsap.set(element, {
                    opacity: 0,
                    y: key === 'title' ? 60 : 40,
                    scale: key === 'button' ? 0.8 : 1
                });

                gsap.to(element, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 1.2,
                    delay: index * 0.2 + 0.5,
                    ease: "power3.out"
                });
            }
        });
    }

    /**
     * Bind scroll events for custom interactions
     */
    bindEvents() {
        // Lenis scroll event for custom animations
        this.lenis.on('scroll', ({ scroll, velocity, direction, progress }) => {
            this.updateScrollProgress(progress);
            this.updateNavbarOnScroll(scroll);
            this.updateCustomCursor(velocity);
        });

        // Smooth anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    this.lenis.scrollTo(target, {
                        offset: -100,
                        duration: 1.5
                    });
                }
            });
        });

        // Resize handler
        window.addEventListener('resize', () => {
            if (this.lenis) {
                this.lenis.resize();
            }
        });
    }

    /**
     * Update scroll progress indicator
     */
    updateScrollProgress(progress) {
        const progressElement = document.querySelector('.progress-wrap svg path');
        if (progressElement) {
            const pathLength = progressElement.getTotalLength();
            progressElement.style.strokeDashoffset = pathLength - (progress * pathLength);
        }
    }

    /**
     * Update navbar appearance based on scroll position
     */
    updateNavbarOnScroll(scroll) {
        const header = document.querySelector('.header-area');
        if (header) {
            if (scroll > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    }

    /**
     * Update custom cursor based on scroll velocity
     */
    updateCustomCursor(velocity) {
        const cursor = document.querySelector('.fn-cursor');
        if (cursor) {
            const scale = 1 + Math.abs(velocity) * 0.002;
            gsap.to(cursor, {
                scale: Math.min(scale, 1.5),
                duration: 0.3,
                ease: "power2.out"
            });
        }
    }

    /**
     * Public method to scroll to element
     */
    scrollTo(target, options = {}) {
        if (this.lenis) {
            this.lenis.scrollTo(target, options);
        }
    }

    /**
     * Public method to stop scrolling
     */
    stop() {
        if (this.lenis) {
            this.lenis.stop();
        }
    }

    /**
     * Public method to start scrolling
     */
    start() {
        if (this.lenis) {
            this.lenis.start();
        }
    }

    /**
     * Portfolio section: staggered card reveal using IntersectionObserver
     * Avoids ScrollTrigger dependency for reliability
     */
    setupPortfolioAnimations() {
        const portfolioItems = document.querySelectorAll('.portfolio-item');
        if (!portfolioItems.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const item = entry.target;
                    const index = parseInt(item.dataset.portfolioIndex || 0);
                    setTimeout(() => {
                        item.classList.add('visible');
                    }, index * 110);
                    observer.unobserve(item);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        portfolioItems.forEach((item, index) => {
            item.dataset.portfolioIndex = index;
            observer.observe(item);
        });

        // Section header fade-in
        const header = document.querySelector('.portfolio-section-header');
        if (header) {
            header.style.opacity = '0';
            header.style.transform = 'translateY(28px)';
            header.style.transition = 'opacity 0.7s ease, transform 0.7s cubic-bezier(0.22, 1, 0.36, 1)';
            const headerObs = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        header.style.opacity = '1';
                        header.style.transform = 'translateY(0)';
                        headerObs.unobserve(header);
                    }
                });
            }, { threshold: 0.2 });
            headerObs.observe(header);
        }
    }

    /**
     * Destroy the scroll experience
     */
    destroy() {
        if (this.lenis) {
            this.lenis.destroy();
            this.lenis = null;
        }
        this.scrollElements.clear();
        this.isInitialized = false;
    }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Wait for GSAP, ScrollTrigger and Lenis to be available
    const initWhenReady = () => {
        if (window.gsap && window.ScrollTrigger && window.Lenis) {
            try {
                window.modernScroll = new ModernScrollExperience();
            } catch (error) {
                console.error('❌ Error initializing modern scroll experience:', error);
                // Fallback: just initialize Lenis without animations
                try {
                    window.lenis = new Lenis({
                        duration: 1.2,
                        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                        direction: 'vertical',
                        smooth: true,
                        mouseMultiplier: 1,
                        smoothTouch: false,
                        touchMultiplier: 2,
                        infinite: false,
                    });
                    
                    const raf = (time) => {
                        window.lenis.raf(time);
                        requestAnimationFrame(raf);
                    };
                    requestAnimationFrame(raf);
                    
                    console.log('✅ Fallback: Basic Lenis scroll initialized');
                } catch (fallbackError) {
                    console.error('❌ Critical error: Could not initialize even basic Lenis:', fallbackError);
                }
            }
        } else {
            setTimeout(initWhenReady, 100);
        }
    };
    initWhenReady();
});

// Make sure ScrollTrigger refreshes after fonts load
document.fonts.ready.then(() => {
    if (window.ScrollTrigger) {
        ScrollTrigger.refresh();
    }
}); 