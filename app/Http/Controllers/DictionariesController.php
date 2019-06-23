<?php

namespace App\Http\Controllers;

use App\Providers\CacheLog;
use App\Providers\TranslateFree;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Royalmar\HtmlDomParser\HtmlDomParser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Search;
//use App\Providers\Personnel;

class DictionariesController extends Controller
{
    public function dictionary()
    {

        $defs = ['', '', '', '', ''];
        $display = '';
        $spelling = '';
        $type = '';
        $example = ['', '', '', '', ''];
        $selectOption = 'E';
        $q = '';

        return view('searches.index')->with('defs', $defs)->with('display', $display)
            ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
            ->with('selectOption', $selectOption)->with('q', $q);
    }

    public function search(Request $request)
    {

        $q = Input::get('q');
        $parser = new \HtmlDomParser();

        $selectOption = $request->input('language');
        if ($selectOption == 'E') {
            $link = 'https://en.oxforddictionaries.com/definition/' . $q;
            $html = $parser->fileGetHtml($link);


            $word = $html->find("span.hw", 0);
            $spelling = $html->find("span.phoneticspelling", 0);

            if (isset($word) == false || isset($spelling) == false) {

                $display = 'No words found';
                $spelling = '';
                $type = '';
                $defs = ['', '', '', '', ''];
                $example = ['', '', '', '', ''];
                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('q', $q);

            } else {
                $searches = DB::table('searches')->select('list')->distinct()->get();

                $n = 0;
                $t = -1;
                $k = 0;
                $display = $word->plaintext;
                $type = $html->find("span.pos", 0)->plaintext;

                $spelling = $html->find("span.phoneticspelling", 0)->plaintext;

                $defs = array();
                for ($i = 0; $i < 5; $i++) {
                    $defs[] = $html->find("span.ind", $i);
                    if (isset($defs[$i]) == false) {
                        $defs[$i] = '';
                    } else {
                        $defs[$i] = $html->find("span.ind", $i)->plaintext;
                    }
                }

                $example = array();
                for ($i = 0; $i < 5; $i++) {
                    $example[] = $html->find(".ex em", $i);
                    if (isset($example[$i]) == false) {
                        $example[$i] = '';
                    } else {
                        $example[$i] = $html->find(".ex em", $i)->plaintext;
                    }
                }
                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('n', $n)->with('q', $q)
                    ->with('searches', $searches)->with('t', $t)->with('k', $k);

            }
        } else if ($selectOption == 'K') {
            $link = 'https://endic.naver.com/search.nhn?sLn=en&isOnlyViewEE=N&query=' . $q;
            $html = $parser->fileGetHtml($link);
            $word = $html->find("span.fnt_e30 strong", 0);

            if (isset($word) == false) {

                $display = 'No words found';
                $spelling = '';
                $type = '';
                $defs = ['', '', '', '', ''];
                $example = '';
                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('q', $q);

            } else {
                $searches = DB::table('searches')->select('list')->get();

                $n = 0;
                $t = -1;
                $k = 0;
                $display = str_replace(' ', '', $word->plaintext);
                $type = '';

                $defs = array();
                for ($i = 0; $i < 5; $i++) {
                    $defs[] = $html->find("span.fnt_k05", $i);
                    if (isset($defs[$i]) == false) {
                        $defs[$i] = '';
                    } else {
                        $defs[$i] = $html->find("span.fnt_k05", $i)->plaintext;
                    }
                }

                $example = array();
                for ($i = 0; $i < 5; $i++) {
                    $example[] = $html->find("div.fnt_k10", $i);
                    if (isset($example[$i]) == false) {
                        $example[$i] = '';
                    } else {
                        $example[$i] = str_replace(' ', '', $html->find("div.fnt_k10", $i)->plaintext);
                    }
                }

                $spelling = '';

                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('n', $n)->with('q', $q)
                    ->with('searches', $searches)->with('t', $t)->with('k', $k);

            }
        } else if ($selectOption == 'V') {
            $link = 'https://vdict.com/' . $q . ',1,0,0.html';
            $html = $parser->fileGetHtml($link);
            $word = $html->find(".word_title", 0);

            if (isset($word) == false) {

                $display = 'No words found';
                $spelling = '';
                $type = '';
                $defs = ['', '', '', '', ''];
                $example = '';
                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('q', $q);

            } else {
                $searches = DB::table('searches')->select('list')->get();

                $n = 0;
                $t = -1;
                $k = 0;
                $display = str_replace(' ', '', $word->plaintext);
                $type = $html->find(".phanloai", 0)->plaintext;

                $defs = array();
                for ($i = 0; $i < 5; $i++) {
                    $defs[] = $html->find(".list1 b", $i);
                    if (isset($defs[$i]) == false) {
                        $defs[$i] = '';
                    } else {
                        $defs[$i] = $html->find(".list1 b", $i)->plaintext . ' ';
                    }
                }

                $example = array();
                for ($i = 0; $i < 5; $i++) {
                    $example[] = $html->find(".list2 span", $i);
                    if (isset($example[$i]) == false) {
                        $example[$i] = '';
                    } else {
                        $example[$i] = '       ' . $html->find(".list2 span", $i)->plaintext . '       ';
                    }
                }

                $spelling = $html->find(".pronounce", 0)->plaintext;

                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('n', $n)->with('q', $q)
                    ->with('searches', $searches)->with('t', $t)->with('k', $k);

            }
        } else if ($selectOption == 'J') {
            $link = "https://tangorin.com/words?search=" .urlencode($q);
            $html = $parser->fileGetHtml($link);
            $word = $html->find(".w-jp dfn", 0);

            if (isset($word) == false) {

                $display = 'No words found';
                $spelling = '';
                $type = '';
                $defs = ['', '', '', '', ''];
                $example = '';
                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('q', $q);

            } else {
                $searches = DB::table('searches')->select('list')->get();

                $n = 0;
                $t = -1;
                $k = 0;
                $display = $word->plaintext;
                $type = $html->find(".w-pos", 0)->plaintext;

                $defs = array();
                for ($i = 0; $i < 5; $i++) {
                    $defs[] = $html->find(".w-def li", $i);
                    if (isset($defs[$i]) == false) {
                        $defs[$i] = '';
                    } else {
                        $defs[$i] = $html->find(".w-def li", $i)->plaintext . ' ';
                    }
                }

                $example = array();
                for ($i = 0; $i < 5; $i++) {
                    $example[] = $html->find(".w-ex-ja", $i);
                    if (isset($example[$i]) == false) {
                        $example[$i] = '';
                    } else {
                        $example[$i] = '       ' . $html->find(".w-ex-ja", $i)->plaintext. $html->find(".w-ex-en", $i)->plaintext . '       ';
                    }
                }

                $spelling = $html->find(".w-jpn-sm", 0)->plaintext;

                return view('searches.index')->with('defs', $defs)->with('display', $display)
                    ->with('spelling', $spelling)->with('type', $type)->with('example', $example)
                    ->with('selectOption', $selectOption)->with('n', $n)->with('q', $q)
                    ->with('searches', $searches)->with('t', $t)->with('k', $k);

            }
        }
    }

    public function test()
    {
        $personnel = new Personnel();

        dd($personnel->uploadFile($_FILES, 'testfile'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'update_image' => 'image|nullable|max:1999'
        ]);

        //Handle file upload
        if ($request->hasFile('update_image')) {

//            $upload = new Personnel();
//            $upload->request = $request;
//
//            $path = $upload->uploadFile($request,'testfile');

            //Get filename with extension
            $fileNameWithExt = $request->file('update_image')->getClientOriginalName();
            //Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('update_image')->guessClientExtension();
            //Upload image
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $nameToDisplay = '/storage/update_images/' . $fileNameToStore;
            //Upload images
            $path = $request->file('update_image')->storeAs('public/update_images/', $fileNameToStore);

        } elseif ($request->input('URLinputBox') !== null) {
            $nameToDisplay = $request->input('URLinputBox');
        } else {
            $nameToDisplay = '/storage/update_images/noimage.jpg';
        }

        if ($request->ajax()) {

            $search = new Search;
            $search->word = $request->input('word');
            $search->definition = $request->input('def');
            $search->type = $request->input('type');
            $search->pronunciation = $request->input('pronunciation');
            $search->example = $request->input('example');
            $search->list = $request->input('newList');
            $search->language = $request->input('lang');
            $search->update_image = $nameToDisplay;
            $search->user_id = auth()->user()->id;
            $search->checked = 0;
            $search->shared = 0;
            $search->clicked = 0;

            $search->save();

            return response($search);
        }
    }

    public function ajaxList()
    {

        $searches = DB::table('searches')->where('user_id', Auth::user()->id)->select('list')->distinct()->get();
        $defs = DB::table('searches')->select(array('definition', 'list'))->get();

        return response(array($searches, $defs));
    }

    public function destroy(Request $request)
    {

        $delDef = $request->input('defDel');
        $delList = $request->input('listDel');

        $search = DB::table('searches')->where('list', $delList)->where('definition', $delDef);

        $countList = DB::table('searches')->where('list', $delList)->count();

        if ($countList === 1) {

            $searches = new Search;
            $searches->word = '';
            $searches->definition = '';
            $searches->type = '';
            $searches->pronunciation = '';
            $searches->example = '';
            $searches->list = $delList;
            $searches->language = '';
            $searches->update_image = '';
            $searches->user_id = Auth::user()->id;
            $searches->checked = 0;
            $search->shared = 0;

            $searches->save();
            $search->delete();
        } else {
            $search->delete();
        }

        return response($delList);

    }
}
