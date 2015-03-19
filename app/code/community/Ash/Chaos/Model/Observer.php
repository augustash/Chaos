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
 * Observer model
 *
 * @category    Ash
 * @package     Ash_Chaos
 * @author      August Ash Team <core@augustash.com>
 */
class Ash_Chaos_Model_Observer
{
    /**
     * Run switch
     *
     * @var boolean
     */
    static protected $_hasRun = false;

    /**
     * Inject values from 'fields.php' into configuration
     *
     * @param   Varien_Event_Observer $observer
     * @return  void
     */
    public function setup(Varien_Event_Observer $observer)
    {
        if ($this->_shouldBail($observer)) {
            return;
        }

        Mage::dispatchEvent('ash_chaos_start_before');

        // retrieve which field's values should be randomly set
        $path   = Mage::getConfig()->getModuleDir('etc', 'Ash_Chaos') . DS . 'fields.php';
        $fields = include $path;
        Mage::getModel('ash_chaos/entropy')->applyConfigNodeCallbacks($fields);

        Mage::dispatchEvent('ash_chaos_start_after');
    }

    /**
     * Determine if extension should continue to run
     *
     * @param   Varien_Event_Observer $observer
     * @return  boolean
     */
    protected function _shouldBail(Varien_Event_Observer $observer)
    {
        $config = Mage::getConfig();

        if (!$config || Mage::app()->getStore()->isAdmin()) {
            return true;
        }

        return false;
    }
}
