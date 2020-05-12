/**
 * Extensions and Overrides for existing JS methods/objects
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 **/

/**
 * Make jQuery's next function loop to first child element if this is the last child
 *
 * @return Object [jQuery type 'object'] - next $(element) if it exists, or returns first $(element) child if subject is last-child
 * @uses $('.selector').Next();
 */
$.fn.Next = function() {
    if ($(this).is(':last-child')) {
        return ($(this).siblings().first());
    } else {
        return ($(this).next());
    }
};

/**
 * Make jQuery's prev function loop to last child element if this is the first child
 *
 * @return Object [jQuery type 'object'] - prev $(element) if it exists, or returns last $(element) child if subject is first-child
 * @uses $('.selector-items').find(:Contains("text-to-find"));
 */
$.fn.Prev = function() {
    if ($(this).is(':first-child')) {
        return ($(this).siblings().last());
    } else {
        return ($(this).prev());
    }
};

/**
 * Make jQuery's Contains non-case-sensitive
 *
 * @return Boolean
 * @uses $('.items-to-search').find(:Contains("text-to-find"));
 */
$.expr[":"].Contains = $.expr.createPseudo(function(arg) {
    return function(elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >=
            0;
    };
});

/**
 * Replace all occurrences of a string
 *
 * @param String search string to be replaced
 * @param String replacement string to replace with
 * @return String
 * @uses str.replaceAll(' ', '')
 */
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

/**
 * Extend Array with new 'containsAny' function for comparing two arrays
 *
 * @return Boolean
 * @uses array1.containsAny(array2);
 */
Array.prototype.containsAny = function(arr) {
    return this.some(function(v) {
        return arr.indexOf(v) >= 0;
    });
};

/**
 * Convert string to title case with JavaScript
 *
 * @return String
 */
String.prototype.toProperCase = function() {
    return this.replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
};
