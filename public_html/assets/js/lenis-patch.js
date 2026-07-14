/**
 * Lenis Integration Patch
 * Disables GSAP ScrollSmoother and other conflicting scroll libraries
 * to ensure Lenis works properly
 */

(function() {
    'use strict';
    
    // Immediately create a mock ScrollSmoother to prevent registration errors
    console.log('🚫 Preemptively disabling GSAP ScrollSmoother for Lenis compatibility');
    
    // Create mock ScrollSmoother before GSAP tries to register it
    window.ScrollSmoother = {
        register: function() {
            console.log('⚠️ ScrollSmoother.register() called but disabled for Lenis');
            return window.ScrollSmoother;
        },
        create: function() {
            console.log('⚠️ ScrollSmoother.create() called but disabled for Lenis');
            return {
                // Return a mock object with essential methods
                kill: () => {},
                refresh: () => {},
                scrollTo: (target, vars) => {
                    // Delegate to Lenis if available
                    if (window.lenis) {
                        window.lenis.scrollTo(target, vars);
                    }
                }
            };
        },
        kill: () => {},
        refresh: () => {}
    };
    
    // Also prevent GSAP from registering the real ScrollSmoother
    const interceptGSAPRegistration = () => {
        if (window.gsap && window.gsap.registerPlugin) {
            const originalRegisterPlugin = window.gsap.registerPlugin;
            window.gsap.registerPlugin = function(...plugins) {
                // Filter out ScrollSmoother from the plugins
                const filteredPlugins = plugins.filter(plugin => {
                    if (plugin && (plugin.name === 'ScrollSmoother' || plugin === window.ScrollSmoother)) {
                        console.log('⚠️ Intercepted ScrollSmoother registration - using mock instead');
                        return false;
                    }
                    return true;
                });
                
                // Register the filtered plugins
                if (filteredPlugins.length > 0) {
                    return originalRegisterPlugin.apply(this, filteredPlugins);
                }
            };
            console.log('✅ GSAP registerPlugin intercepted successfully');
        }
    };

    // Continuously poll for GSAP until it's available
    const pollForGSAP = () => {
        if (window.gsap && window.gsap.registerPlugin) {
            interceptGSAPRegistration();
        } else {
            setTimeout(pollForGSAP, 10);
        }
    };

    // Start polling immediately
    pollForGSAP();

    // Also intercept when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        interceptGSAPRegistration();
    });

    // Remove smooth-scroll class if present to prevent conflicts
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.remove('smooth-scroll');
        console.log('🧹 Removed smooth-scroll class for Lenis compatibility');
    });

    // Override any existing smooth scroll initialization
    window.addEventListener('load', function() {
        // Disable any smooth scroll plugins
        if (window.SmoothScroll) {
            console.log('🚫 Disabling SmoothScroll plugin for Lenis compatibility');
            if (typeof window.SmoothScroll.destroy === 'function') {
                window.SmoothScroll.destroy();
            }
        }

        // Remove any scroll-behavior CSS that might conflict
        const style = document.createElement('style');
        style.textContent = `
            * {
                scroll-behavior: auto !important;
            }
            html {
                scroll-behavior: auto !important;
            }
            body {
                scroll-behavior: auto !important;
            }
        `;
        document.head.appendChild(style);
    });

    console.log('✅ Lenis patch applied successfully');
})(); 