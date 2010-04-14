<?php
/**
 * Joy Web Framework
 *
 * Copyright (c) 2008-2009 Netology Foundation (http://www.netology.org)
 * All rights reserved.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL.
 */

/**
 * @package     Joy
 * @subpackage  Page
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
abstract class Joy_Page_Abstract extends Joy_Context implements Joy_Page_Interface
{
    protected function _registerEvents()
    {
        parent::_registerEvents();

        // page.init uygulama için ek objeleri ekleyebilirsiniz.
        $this->event->register("page.init", $this, "onInit");

        // page.load uygulamanın çalıştırılmaya hazır olduğu halidir.
        $this->event->register("page.load", $this, "onLoad");

        // page.assign kısmında action çalıştırılmış ve assign edilecek dataya manipülasyon yapılmasına izin verilen halidir.
        $this->event->register("page.assign", $this, "onAssign");

        // page.resource ise css ve js include listelerinde manipülasyon yapılabilmesine izin verir.
        $this->event->register("page.resource", $this, "onResource");

        // page.render kısmında ise render edilen metin içerisinde oynama yapılabilir. 
        $this->event->register("page.render", $this, "onRender"); 

        // page.disposal kısımda ise sayfa ekrana basılmış olur ve tüm sayfa verisi öldürülür.
        $this->event->register("page.disposal", $this, "onDisposal"); 
    }

    public function build()
    {
        $this->event->dispatcher("page.load");

        // Call Action Method In Controller 
        $current = $this->request->getAction();
        $view = $current->controller->action($current->action->name, $current->action->arguments);

        if (null == $view) {
            $view = new Joy_View_Empty();
        }

        $render = $this->response->getRender();
        $output = $render->execute($view);
        $this->event->dispatcher("page.render", &$output);

        header("Content-Type: {$render->getContentType()}");
        print $output;
    }
}
