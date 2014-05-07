<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05.03.14
 * Time: 23:43
 */

// rewrite rule
add_filter('rewrite_rules_array', 'wp_insertMyRewriteRules');
add_filter('query_vars', 'wp_insertMyRewriteQueryVars');
//add_filter('init','flushRules');

// Remember to flush_rules() when adding rules
function flushRules()
{
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}


// Adding a new rule
function wp_insertMyRewriteRules($rules)
{
		$newrules = array();
		$newrules['programm/(.+)/(.+)'] = 'index.php?pagename=programm&month=$matches[1]&year=$matches[2]';
		$newrules['api/(.+)/(.+)'] = 'index.php?pagename=api&type=$matches[1]&year=$matches[2]';
		$finalrules = $newrules + $rules;
		return $finalrules;
}

// Adding the var so that WP recognizes it
function wp_insertMyRewriteQueryVars($vars)
{
		array_push($vars, 'month');
		array_push($vars, 'year');
		return $vars;
}



//Stop wordpress from redirecting
remove_filter('template_redirect', 'redirect_canonical');