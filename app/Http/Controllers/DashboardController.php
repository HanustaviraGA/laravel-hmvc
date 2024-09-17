<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\SysMenu;

class DashboardController extends Controller
{
    public function index(Request $request){
        if (Auth::check()) {
            $destination = 'dashboard';
            $ucf = ucfirst($destination);

            // Role
            $role = Auth::user()->role_id;
            $isi_roles = [];
            $query = DB::table('view_sys_role_menu')
            ->where('role_id', $role)
            ->where('menu_aktif', '1')
            ->select('menu_kode')
            ->get();
            foreach($query as $values){
                $isi_roles[] = $values->menu_kode;
            }
            $roles = json_encode($isi_roles);

            // Header
            $header = '<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="kt_header_menu" data-kt-menu="true">';
            $query = SysMenu::where('menu_aktif', 1)->whereHas('roles', function ($query) use ($role) {
                $query->where('role_id', $role);
            })->orderBy('menu_order', 'asc')->get();
            foreach($query as $values){
                if($values['menu_parent'] == '#'){
                    if($values['menu_kode'] == 'home'){
                        $header .= '
                        <div class="menu-item me-lg-1">
                            <a onclick="loadSidebar(this)" data-id="' . $values['menu_id'] . '" data-page="' . $values['menu_kode'] . '" data-name="' . $values['menu_judul'] . '" class="menu-link active py-3">
                                <span class="menu-title spns" id="menu-' . $values['menu_judul'] . '">' . $values['menu_judul'] . '</span>
                            </a>
                        </div>';
                    }else{
                        $header .= '
                        <div class="menu-item me-lg-1">
                            <a onclick="loadSidebar(this)" data-id="' . $values['menu_id'] . '" data-page="' . $values['menu_kode'] . '" data-name="' . $values['menu_judul'] . '" class="menu-link py-3">
                                <span class="menu-title spns" id="menu-' . $values['menu_judul'] . '">' . $values['menu_judul'] . '</span>
                            </a>
                        </div>';
                    }
                }
            }
            $header .= '</div>';

            // Sidebar
            $sidebar = '<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="kt_aside_menu" data-kt-menu="true">';
            // Level 1 - Judul Menu
            $start = SysMenu::where('menu_aktif', 1)->where('menu_level', 1)->whereHas('roles', function ($query) use ($role) {
                $query->where('role_id', $role);
            })->orderBy('menu_order', 'asc')->get();

            foreach($start as $judul){
                $sidebar .= '
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">'.$judul['menu_judul'].'</span>
                    </div>
                </div>';
                if($judul['menu_sub']){
                    // Level 2 - Sub Menu Level 2
                    $start_c1 = SysMenu::where('menu_aktif', 1)->where('menu_level', 2)->where('menu_parent', $judul['menu_id'])->whereHas('roles', function ($query) use ($role) {
                        $query->where('role_id', $role);
                    })->orderBy('menu_order', 'asc')->get();
                    foreach($start_c1 as $values){
                        if($values['menu_sub'] == 1){
                            // Level 3 - Sub Menu Level 3
                            $extend = SysMenu::where('menu_aktif', 1)
                            ->where('menu_parent', $values['menu_id'])
                            ->where('menu_level', 3)
                            ->whereHas('roles', function ($query) use ($role) {
                                $query->where('role_id', $role);
                            })
                            ->orderBy('menu_order', 'asc')
                            ->get();
                            $sidebar .= '<div data-kt-menu-trigger="click" class="menu-item menu-accordion">';
                            foreach($extend as $valext){
                                if($valext['menu_sub'] == 1){
                                    // Level 4 - Sub Menu Level 4
                                    $realext = SysMenu::where('menu_aktif', 1)
                                    ->where('menu_parent', $valext['menu_id'])
                                    ->where('menu_level', 4)
                                    ->whereHas('roles', function ($query) use ($role) {
                                        $query->where('role_id', $role);
                                    })
                                    ->orderBy('menu_order', 'asc')
                                    ->get();
                                    $sidebar .= '<div class="menu-sub menu-sub-accordion">';
                                    foreach($realext as $vrrealext){
                                        $sidebar .= '
                                        <div class="menu-item">
                                            <a data-page="' . $vrrealext['menu_judul'] . '" id="lnk-'.$vrrealext['menu_kode'].'" class="menu-link" href="/'.$vrrealext['menu_kode'].'" data-navigo>
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">'.$vrrealext['menu_judul'].'</span>
                                            </a>
                                        </div>';
                                    }
                                    $sidebar .= '</div>';
                                }else{
                                    $sidebar .= '
                                    <div class="menu-item">
                                        <a data-page="' . $valext['menu_judul'] . '" id="lnk-'.$valext['menu_kode'].'" class="menu-link" href="/'.$valext['menu_kode'].'" data-navigo>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">'.$valext['menu_judul'].'</span>
                                        </a>
                                    </div>';
                                }
                            }
                            $sidebar .= '</div>';
                        }else{
                            if($values['menu_kode'] == 'dashboard'){
                                $sidebar .= '
                                <div class="menu-item">
                                    <a data-page="' . $values['menu_judul'] . '" id="lnk-'.$values['menu_kode'].'" class="menu-link active" href="/" data-navigo>
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">'.$values['menu_judul'].'</span>
                                    </a>
                                </div>';
                            }else{
                                $sidebar .= '
                                <div class="menu-item">
                                    <a data-page="' . $values['menu_judul'] . '" id="lnk-'.$values['menu_kode'].'" class="menu-link" href="/'.$values['menu_kode'].'" data-navigo>
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">'.$values['menu_judul'].'</span>
                                    </a>
                                </div>';
                            }
                        }
                    }
                }
            }

            $sidebar .='</div>';

            return view('dashboard.index', compact('destination', 'ucf', 'roles', 'header', 'sidebar'));
        }else{
            Session::flash('error', 'Silakan login terlebih dahulu !');
            return view('login');
        }
    }

    public function index_spec($any){
        if (Auth::check()) {
            $destination = $any;
            $ucf = ucfirst($destination);
            // Role
            $role = Auth::user()->role_id;
            $isi_roles = [];
            $query = DB::table('view_sys_role_menu')
            ->where('role_id', $role)
            ->where('menu_aktif', '1')
            ->select('menu_kode')
            ->get();
            foreach($query as $values){
                $isi_roles[] = $values->menu_kode;
            }
            $roles = json_encode($isi_roles);
            // Sidebar
            $sidebar = '<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="kt_aside_menu" data-kt-menu="true">';
            // Level 1 - Judul Menu
            $start = SysMenu::where('menu_aktif', 1)->where('menu_level', 1)->whereHas('roles', function ($query) use ($role) {
                $query->where('role_id', $role);
            })->orderBy('menu_order', 'asc')->get();

            foreach($start as $judul){
                $sidebar .= '
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">'.$judul['menu_judul'].'</span>
                    </div>
                </div>';
                if($judul['menu_sub']){
                    // Level 2 - Sub Menu Level 2
                    $start_c1 = SysMenu::where('menu_aktif', 1)->where('menu_level', 2)->where('menu_parent', $judul['menu_id'])->whereHas('roles', function ($query) use ($role) {
                        $query->where('role_id', $role);
                    })->orderBy('menu_order', 'asc')->get();
                    foreach($start_c1 as $values){
                        if($values['menu_sub'] == 1){
                            // Level 3 - Sub Menu Level 3
                            $extend = SysMenu::where('menu_aktif', 1)
                            ->where('menu_parent', $values['menu_id'])
                            ->where('menu_level', 3)
                            ->whereHas('roles', function ($query) use ($role) {
                                $query->where('role_id', $role);
                            })
                            ->orderBy('menu_order', 'asc')
                            ->get();
                            $sidebar .= '<div data-kt-menu-trigger="click" class="menu-item menu-accordion">';
                            foreach($extend as $valext){
                                if($valext['menu_sub'] == 1){
                                    // Level 4 - Sub Menu Level 4
                                    $realext = SysMenu::where('menu_aktif', 1)
                                    ->where('menu_parent', $valext['menu_id'])
                                    ->where('menu_level', 4)
                                    ->whereHas('roles', function ($query) use ($role) {
                                        $query->where('role_id', $role);
                                    })
                                    ->orderBy('menu_order', 'asc')
                                    ->get();
                                    $sidebar .= '<div class="menu-sub menu-sub-accordion">';
                                    foreach($realext as $vrrealext){
                                        $sidebar .= '
                                        <div class="menu-item">
                                            <a data-page="' . $vrrealext['menu_judul'] . '" id="lnk-'.$vrrealext['menu_kode'].'" class="menu-link" href="/'.$vrrealext['menu_kode'].'" data-navigo>
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">'.$vrrealext['menu_judul'].'</span>
                                            </a>
                                        </div>';
                                    }
                                    $sidebar .= '</div>';
                                }else{
                                    $sidebar .= '
                                    <div class="menu-item">
                                        <a data-page="' . $valext['menu_judul'] . '" id="lnk-'.$valext['menu_kode'].'" class="menu-link" href="/'.$valext['menu_kode'].'" data-navigo>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">'.$valext['menu_judul'].'</span>
                                        </a>
                                    </div>';
                                }
                            }
                            $sidebar .= '</div>';
                        }else{
                            if($values['menu_kode'] == 'dashboard'){
                                $sidebar .= '
                                <div class="menu-item">
                                    <a data-page="' . $values['menu_judul'] . '" id="lnk-'.$values['menu_kode'].'" class="menu-link active" href="/" data-navigo>
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">'.$values['menu_judul'].'</span>
                                    </a>
                                </div>';
                            }else{
                                $sidebar .= '
                                <div class="menu-item">
                                    <a data-page="' . $values['menu_judul'] . '" id="lnk-'.$values['menu_kode'].'" class="menu-link" href="/'.$values['menu_kode'].'" data-navigo>
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">'.$values['menu_judul'].'</span>
                                    </a>
                                </div>';
                            }
                        }
                    }
                }
            }

            $sidebar .='</div>';
            return view('dashboard.index', compact('destination', 'ucf', 'roles', 'sidebar'));
        }else{
            Session::flash('error', 'Silakan login terlebih dahulu !');
            return view('login');
        }
    }
}
