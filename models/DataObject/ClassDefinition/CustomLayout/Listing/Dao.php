<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Model\DataObject\ClassDefinition\CustomLayout\Listing;

use Pimcore\Model;

/**
 * @internal
 *
 * @property \Pimcore\Model\DataObject\ClassDefinition\CustomLayout\Listing $model
 */
class Dao extends Model\Listing\Dao\AbstractDao
{
    /**
     * Loads a list of custom layouts for the specified parameters, returns an array of DataObject\ClassDefinition\CustomLayout elements
     *
     * @return array
     */
    public function load()
    {
        $layouts = [];

        $layoutsRaw = $this->db->fetchFirstColumn('SELECT id FROM custom_layouts' . $this->getCondition() . $this->getOrder() . $this->getOffsetLimit(), $this->model->getConditionVariables());

        foreach ($layoutsRaw as $classRaw) {
            $customLayout = Model\DataObject\ClassDefinition\CustomLayout::getById($classRaw);
            if ($customLayout) {
                $layouts[] = $customLayout;
            }
        }

        $this->model->setLayoutDefinitions($layouts);

        return $layouts;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        try {
            return (int) $this->db->fetchOne('SELECT COUNT(*) FROM custom_layouts ' . $this->getCondition(), $this->model->getConditionVariables());
        } catch (\Exception $e) {
            return 0;
        }
    }
}
