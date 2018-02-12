# sf-bb-plugin
## Beaver Builder Integration for Search &amp; Filter 

### Overview
Provides basic integration of the designandcode.com Search & Filter Pro plugin with Beaver Builder page builder.

BeaverBuilder Module
- allows drop-down selection of configured S&F configurations (developer calls them widgets)
- allows for custom CSS that is inline inserted before the S&F Controls

Extends the BB Post Module
- adds configured S&F modules to the Content Tab \ Data-Source

### Configuration

Install as a standard Wordpress Plugin

### Implementation

Enable the BB Module through site Settings \ Page Builder in WP Admin

S&F Configuration
- Display Results Method = Custom
- Results URL - must be specified if using AJAX
- AJAX Container = .fl-module-post-grid
- Pagination Selector = .fl-builder-pagination a

BB Post Module
- Layout - only Columns currently supported

### Known Limitations and bugs

- pagination issues, continuous scroll seems to work but other dont as yet, load more and page-by-page needs to be figured out
- BB Post layout only Columns is supported
- Results URL must be specified in S&F configuration which limits reusability of S&F configurations across pages
- After publishing a page you sometimes need to do a page-refresh in order for filtering to work
- Only one S&F module instance per page

### Acknowledgments

This code significantly leverages the BB integration work done by FacetWP LLC and their Beaver Builder Integration plugin. FacetWP is a Search and Filtering plugin for Wordpress that provides a number of features and extensions that Search & Filter does not currently provide - http://www.facetwp.com
