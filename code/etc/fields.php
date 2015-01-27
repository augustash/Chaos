<?php
/**
* The MIT License (MIT)
*
* Copyright (c) 2015 Alan Storm
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

/**
 * Chaos allows a programmer the ability to assign random configuration values
 * at runtime.
 *
 * @category    Ash
 * @package     Ash_Chaos
 * @copyright   Copyright (c) 2015 August Ash, Inc. (http://www.augustash.com)
 */

/*
 * Returns an array of node/callback pairs. The callback will be used to generate
 * a random runtime value for the configuration node in non-admin pages. The value
 * swap occurs pre-controller action dispatch.
 *
 * The callback is a PHP callback pseudo-type. Also, before checking the callability
 * of the callback, Chaos will check a local helper/domain-model for a method.
 * This local object "trumps" any PHP callback that is found.
 */

return array(
    'catalog/frontend/flat_catalog_category' => 'getRandomBoolean',
    'catalog/frontend/flat_catalog_product'  => 'getRandomBoolean',
    // 'design/theme/default'                   => function(){
    //     $themes = array('snowden', 'default');
    //     return $themes[rand(0, 1)];
    // }
);
