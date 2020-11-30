<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Auth;

trait ControllerHandler
{
  /**
   * Handle controller startup
   *
   * @return void
   */
  private function defaultHandler()
  {
    if (!Auth::user()->can($this->getDefaultHandlers()))
      return response()->redirect(url("error", ["code" => 403]));
  }

  /**
   * Undocumented function
   *
   * @param array $permissions
   * @return void
   */
  public function runHandler(array $permissions = [])
  {
    $this->defaultHandler();

    if (!Auth::user()->can($permissions))
      return response()->redirect(url("error", ["code" => 403]));
  }

  private function getDefaultHandlers()
  {
    return $this->defaultHandlers ?? [];
  }
}
