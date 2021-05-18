<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Mail;

use Applications\Mail\NewApplication as ApplicationsNewApplication;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class NewApplication extends ApplicationsNewApplication
{
    use StringTemplateHtmlMailTrait;

    public function setVariables($variables = array())
    {
        if (isset($variables['link'])) {
            $variables['link'] = preg_replace('/\s+/', ' ',
            sprintf(
              '<table border="0"
              cellpadding="0"
              cellspacing="0"
              width="50%%"
              style="background-color: #7b1738;">
              <tr>
                <td align="center"
                  valign="middle"
                  style="padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;"
                >
                  <a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%%;"
                    href="%1$s" target="_blank"
                  >zur Bewerbung</a>
                </td>
              </tr>
            </table>
              ',
              $variables['link']
          ));
        }

        return parent::setVariables($variables);
    }
}
