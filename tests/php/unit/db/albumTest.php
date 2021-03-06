<?php

/**
 * ownCloud - Music app
 *
 * @author Morris Jobke
 * @copyright 2013 Morris Jobke <morris.jobke@gmail.com>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\Music\Db;


/* FIXME: dirty hack to mock object */
class AlbumTestView {
	public function getPath($fileId) {
		return $fileId;
	}
}


class AlbumTest extends \PHPUnit_Framework_TestCase {

	private $api;

	protected function setUp() {
		$this->api = $this->getMockBuilder(
			'\OCA\Music\AppFramework\Core\API')
			->disableOriginalConstructor()
			->getMock();

		/* FIXME: dirty hack to mock object */
		$this->api->expects($this->any())
			->method('getView')
			->will($this->returnValue(new AlbumTestView()));
	}

	public function testToAPI() {
		$album = new Album();
		$album->setId(3);
		$album->setName('The name');
		$album->setYear(2013);
		$album->setCoverFileId(5);
		$album->setArtistIds(array(1,2));

		$this->assertEquals(array(
			'id' => 3,
			'name' => 'The name',
			'year' => 2013,
			'cover' => null,
			'slug' => '3-the-name',
			'artists' => array(
				array('id' => 1, 'uri' => null),
				array('id' => 2, 'uri' => null)
			),
			'uri' => null
			), $album->toAPI($this->api));
	}

}