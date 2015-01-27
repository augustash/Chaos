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

/**
 * Entropy model
 *
 * @category    Ash
 * @package     Ash_Chaos
 * @author      August Ash Team <core@augustash.com>
 */
class Ash_Chaos_Model_Entropy
{
    /**
     * Set configuration values to a random boolean
     *
     * @param   array $nodes
     * @return  void
     */
    public function applyConfigNodeCallbacks($nodes)
    {
        $config      = Mage::getConfig();
        $storeCode   = Mage::app()->getStore()->getCode();
        $valueHelper = Mage::getSingleton('ash_chaos/values');

        foreach($nodes as $path => $value)
        {
            $callback = array($valueHelper, $value);
            if (is_callable($callback)) {
                $config->setNode("stores/$storeCode/" . $path, call_user_func($callback));
            } elseif (is_callable($value)) {
                $config->setNode("stores/$storeCode/" . $path, call_user_func($value));
            } else {
                throw new Exception("Callback $value not found");
            }
        }
    }
}
