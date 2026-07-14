# Lenis JS Integration Guide

## 🎯 Overview

This integration transforms your website's scrolling experience using **Lenis JS** for ultra-smooth scrolling and modern scroll-driven animations inspired by **comet.perplexity.ai**.

### ✨ Features Implemented

- **Smooth Scrolling**: Ultra-fluid scrolling with custom easing
- **Fade-in Animations**: Subtle element reveals as they enter viewport
- **Parallax Effects**: Gentle background movement for depth
- **Scale Animations**: Interactive element scaling with bounce effects
- **Stagger Animations**: Sequential animations for lists and grids
- **Counter Animations**: Animated number counting on scroll
- **Hero Animations**: Sophisticated hero section entrance
- **Scroll Progress**: Enhanced progress indicators
- **Dynamic Header**: Navbar transforms on scroll
- **Smooth Anchors**: Seamless navigation to sections

## 📁 Files Structure

```
public_html/
├── assets/js/
│   ├── lenis-scroll.js     # Main Lenis integration & animations
│   └── lenis-patch.js      # Conflict resolution patch
└── index.html              # Updated with Lenis CDN & scripts
```

## 🚀 Implementation Steps

### 1. Include Required Scripts

Add these scripts to your HTML pages in this exact order:

```html
<!-- GSAP and ScrollTrigger (required for Lenis integration) -->
<script defer src="assets/js/vendor/gsap.js"></script>
<script defer src="assets/js/plugins/scrolltrigger.js"></script>
<script defer src="assets/js/plugins/scrolltoplugin.js"></script>
<script defer src="assets/js/plugins/splittext.js"></script>

<!-- Lenis Integration Patch (disables conflicting scroll libraries) -->
<script src="assets/js/lenis-patch.js"></script>

<!-- Lenis Smooth Scrolling CDN -->
<script src="https://unpkg.com/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

<!-- Modern Scroll Experience (replaces old smooth scroll libraries) -->
<script defer src="assets/js/lenis-scroll.js"></script>
```

### 2. Remove Conflicting HTML Structure

**REMOVE** the old smooth wrapper structure:

```html
<!-- OLD - Remove this -->
<div id="smooth-wrapper">
    <div id="smooth-content">
        <!-- Your content -->
    </div>
</div>

<!-- NEW - Direct content -->
<!-- Your content directly in body -->
```

### 3. Update CSS for Lenis

Add these critical CSS overrides:

```css
/* Override conflicting scroll behaviors */
html {
    scroll-behavior: auto !important;
}

body {
    overflow-x: hidden;
}

/* Header scroll state for Lenis integration */
.header-area {
    transition: all 0.3s ease;
}

.header-area.scrolled {
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Lenis scroll progress indicator enhancement */
.progress-wrap {
    transition: all 0.3s ease;
}

.progress-wrap.active {
    opacity: 1;
    visibility: visible;
}
```

### 4. Apply to All Pages

Update these files with the same integration:

- `index.html` ✅ (Already done)
- `about.html`
- `services.html`
- `pricing.html`
- `contact.php`
- `privacy-policy.html`
- `terms-of-service.html`
- Error pages: `404.html`, `403.html`, `400.html`, `500.html`, `503.html`

## 🎨 Animation Details

### Fade-in Animations
- **Targets**: Sections, service items, approach areas
- **Effect**: Opacity 0→1, Y-translate 30px→0, Scale 0.98→1
- **Timing**: 0.8s duration, staggered by 0.1s per element
- **Trigger**: When element reaches 85% from top

### Parallax Effects
- **Targets**: Banner areas, hero sections, dark backgrounds
- **Effect**: Subtle vertical movement at different speeds
- **Performance**: Uses `transform3d` for GPU acceleration
- **Speed**: 0.2-0.5x scroll speed for subtle effect

### Scale Animations
- **Targets**: Hero titles, logos, interactive elements
- **Effect**: Scale 0.9→1 with bounce easing
- **Timing**: 1s duration with `back.out(1.7)` easing
- **Purpose**: Draw attention to key elements

### Stagger Animations
- **Targets**: Navigation items, footer links, lists
- **Effect**: X-translate -20px→0, opacity 0→1
- **Timing**: 0.6s duration, 0.1s stagger between items
- **Purpose**: Create flowing, sequential reveals

### Counter Animations
- **Targets**: Numeric counters in stats sections
- **Effect**: Count from 0 to target number
- **Timing**: 2s duration with snapping to integers
- **Trigger**: When counter enters 80% viewport

## 🔧 Configuration Options

### Lenis Settings
```javascript
const lenis = new Lenis({
    duration: 1.2,           // Scroll duration (1.2s)
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Custom easing
    direction: 'vertical',   // Scroll direction
    smooth: true,           // Enable smooth scrolling
    mouseMultiplier: 1,     // Mouse wheel sensitivity
    smoothTouch: false,     // Disable on touch for performance
    touchMultiplier: 2,     // Touch sensitivity
    infinite: false,        // No infinite scroll
});
```

### Performance Optimizations
- **GPU Acceleration**: Uses `transform3d` for animations
- **Will-change**: Applied to animating elements
- **Reduced Motion**: Respects user preferences
- **Touch Optimization**: Disabled smooth scrolling on touch devices

## 🎯 Inspiration Analysis

Based on **comet.perplexity.ai**, the animations focus on:

1. **Subtlety**: Gentle, non-intrusive movements
2. **Performance**: Smooth 60fps animations
3. **Purpose**: Each animation serves a UX purpose
4. **Cohesion**: Consistent timing and easing across all effects
5. **Accessibility**: Respects reduced motion preferences

## 🛠️ Customization

### Adding New Animated Elements

1. **Add to selectors array** in `lenis-scroll.js`:
```javascript
const fadeElements = [
    '.your-new-selector',
    // ... existing selectors
];
```

2. **Create custom animation**:
```javascript
setupCustomAnimation() {
    const elements = document.querySelectorAll('.your-selector');
    elements.forEach(element => {
        gsap.set(element, { /* initial state */ });
        
        ScrollTrigger.create({
            trigger: element,
            start: "top 85%",
            onEnter: () => {
                gsap.to(element, { /* animation */ });
            }
        });
    });
}
```

### Adjusting Animation Timing

Modify these values in `lenis-scroll.js`:

```javascript
// Fade duration
duration: 0.8,

// Stagger delay
delay: index * 0.1,

// Trigger points
start: "top 85%",
end: "bottom 15%",
```

## 🐛 Troubleshooting

### Common Issues

1. **Animations not working**
   - Check browser console for errors
   - Ensure GSAP and ScrollTrigger load before Lenis
   - Verify selectors match your HTML structure

2. **Conflicting scroll behavior**
   - Ensure `lenis-patch.js` loads first
   - Check for `scroll-behavior: smooth` in CSS
   - Remove other smooth scroll libraries

3. **Performance issues**
   - Reduce animation duration
   - Limit number of animated elements
   - Use `will-change: transform` sparingly

### Debug Mode

Enable debug logging:
```javascript
// In lenis-scroll.js, add:
ScrollTrigger.config({ debug: true });
```

## 📱 Mobile Considerations

- Smooth scrolling disabled on touch devices for performance
- Reduced animation complexity on mobile
- Touch-optimized scroll sensitivity
- Responsive animation triggers

## 🎮 API Usage

### Global Access
```javascript
// Scroll to element
window.modernScroll.scrollTo('#section', { offset: -100 });

// Stop scrolling
window.modernScroll.stop();

// Start scrolling
window.modernScroll.start();

// Direct Lenis access
window.lenis.scrollTo(500);
```

### Event Listening
```javascript
window.lenis.on('scroll', ({ scroll, velocity, direction, progress }) => {
    // Custom scroll logic
});
```

## 🚀 Production Checklist

- [ ] All pages include Lenis scripts in correct order
- [ ] Smooth wrapper structure removed from all pages
- [ ] CSS conflicts resolved
- [ ] Animations tested on all target browsers
- [ ] Performance validated on mobile devices
- [ ] Accessibility tested with reduced motion
- [ ] Debug mode disabled for production

## 📊 Performance Metrics

Expected improvements:
- **Scroll smoothness**: 60fps consistent
- **Animation fluidity**: Hardware accelerated
- **User engagement**: Increased time on site
- **Professional feel**: Modern, polished experience

---

**Implementation completed for index.html** ✅  
**Ready to apply to remaining pages** 🚀 