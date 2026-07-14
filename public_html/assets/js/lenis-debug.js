/**
 * Lenis Debug Helper
 * Use this to troubleshoot the integration
 */

(function() {
    'use strict';
    
    console.log('🔍 Lenis Debug Helper Started');
    
    // Track script loading
    const scriptsLoaded = {
        gsap: false,
        scrollTrigger: false,
        lenis: false,
        lenisScroll: false
    };
    
    // Check what's loaded
    const checkLoadedScripts = () => {
        scriptsLoaded.gsap = !!(window.gsap);
        scriptsLoaded.scrollTrigger = !!(window.ScrollTrigger);
        scriptsLoaded.lenis = !!(window.Lenis);
        scriptsLoaded.lenisScroll = !!(window.modernScroll);
        
        console.log('📊 Scripts Status:', scriptsLoaded);
        
        if (window.gsap) {
            console.log('✅ GSAP Version:', window.gsap.version);
        }
        
        if (window.ScrollTrigger) {
            console.log('✅ ScrollTrigger available');
        }
        
        if (window.Lenis) {
            console.log('✅ Lenis available');
        }
        
        if (window.ScrollSmoother) {
            console.log('⚠️ ScrollSmoother detected:', typeof window.ScrollSmoother);
        }
        
        if (window.lenis) {
            console.log('✅ Lenis instance found:', window.lenis);
        }
        
        if (window.modernScroll) {
            console.log('✅ Modern scroll experience found:', window.modernScroll);
        }
    };
    
    // Check every 500ms for the first 10 seconds
    let checkCount = 0;
    const maxChecks = 20;
    
    const intervalId = setInterval(() => {
        checkCount++;
        console.log(`🔍 Check ${checkCount}/${maxChecks}:`);
        checkLoadedScripts();
        
        if (checkCount >= maxChecks || (scriptsLoaded.gsap && scriptsLoaded.scrollTrigger && scriptsLoaded.lenis && scriptsLoaded.lenisScroll)) {
            clearInterval(intervalId);
            console.log('🏁 Debug helper finished');
        }
    }, 500);
    
    // Also check on load events
    document.addEventListener('DOMContentLoaded', () => {
        console.log('📋 DOM Content Loaded - checking scripts:');
        checkLoadedScripts();
    });
    
    window.addEventListener('load', () => {
        console.log('🎯 Window Load Complete - final check:');
        checkLoadedScripts();
    });
    
    // Test scroll after everything should be loaded
    setTimeout(() => {
        console.log('🧪 Testing scroll functionality:');
        
        if (window.lenis) {
            try {
                window.lenis.scrollTo(100, { duration: 1 });
                console.log('✅ Lenis scroll test successful');
                
                setTimeout(() => {
                    window.lenis.scrollTo(0, { duration: 1 });
                }, 2000);
            } catch (error) {
                console.error('❌ Lenis scroll test failed:', error);
            }
        } else {
            console.warn('⚠️ No Lenis instance available for testing');
        }
    }, 5000);
    
})();

console.log('🔧 Lenis Debug Helper Loaded'); 