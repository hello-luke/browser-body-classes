# Browser Body Classes (WordPress Plugin)

![preview](https://raw.github.com/hello-luke/browser-body-classes/master/public/assets/img/preview.jpg)
----
This lightweight plugin allows you to add unique classes to the body tag for easy styling based on user's device and browser. It can be very useful especially if you are creating own theme.


## Installation

Installing and using Browser Body Class:  

-Upload /browser-body-class/ to the '/wp-content/plugins/' directory.  
-Activate the plugin through the 'Plugins' menu in WordPress.  
-Setup your settings via 'Settings > Browser Body Class'.  

## Possible classes examples

**Device type:**  
desktop, tablet, phone

**OS:**  
mac, windows, linux, unix, android, ios, windows-phone, amazon

**Browser info:**  
chrome, firefox, safari, opera,ie

**Browser version:**  
ie11, chrome48, safari9 etc.

**Device orientation (only phones and tablets):**  
landscape, portrait, orientation-changed

## Example usage

How to target example class:

```css
/*Targeting only all versions of Chrome browser:*/
body.chrome .example{}

/*Targeting IE11:*/
body.ie11 .example{}

/*targeting only tablets*/
body.tablet .example{}

/*targeting iphones:*/
body.phone.ios .example{}
```

## License

**License:**           GPL-2.0+  
**License URI:**       http://www.gnu.org/licenses/gpl-2.0.txt

## Credits:
**kaimallea** - detecting mobile features with [isMobile](https://github.com/kaimallea/isMobile)
