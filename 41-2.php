<?php
const STONE = 0;
const SCISSORS = 1;
const PAPER = 2;

const HAND_TYPE = array(
    STONE => 'グー',
    SCISSORS => 'チョキ',
    PAPER => 'パー'
);

//勝敗判定用
const DRAW = 0;
const WIN = 1;
const LOSS = 2;
//バリデーション用
const OVER = 2;
//ゲームを継続
const SELECT = 1;

janken();
function janken()
{
    $myhand = inputMyHand();
    $comhand = getComHand();
    $result = judge($myhand, $comhand);
    show($result);
    $keepgoing = selectContinue();
    if ($keepgoing === true) {
        return janken(); //returnを忘れずに
    }
}
//handの取得
function getComHand()
{
    $comhand = array_rand(HAND_TYPE);
    return $comhand; //0,1,2のどれかを出力
}
//入力
function inputMyHand()
{
    echo '最初は、グー！じゃんけんぽん！';
    $myhand = trim(fgets(STDIN));
    $check = myHandCheck($myhand);
    if ($check === false) {
        return inputMyHand(); //再度入力してもらう
    }
    return (int)$myhand;
}
//勝敗の取得
function judge($myhand, $comhand)
{
    $result = ($myhand - $comhand + 3) % 3; //0,1,2のどれかを出力
    return $result;
}
//結果の表示
function show($result)
{
    if ($result === DRAW) { //右側の定数は全ての手で一致する。
        echo "あいこ" . PHP_EOL;
    } elseif ($result === WIN) {
        echo "勝ち" . PHP_EOL;
    } elseif ($result === LOSS) {
        echo "負け" . PHP_EOL;
    }
}
//バリデーション
function myHandCheck($myhand)
{
    if (!is_numeric($myhand)) { //strlenを使う方法もある
        echo '0,1,2のどれかを入力してください' . PHP_EOL;
        return false;
    }
    // HAND_TYPEのキーに存在しない
    if ($myhand != STONE && $myhand != SCISSORS && $myhand != PAPER) {
        echo '一致しない値です' . PHP_EOL;
        return false;
    }
    return true;
}
//ゲームを続けるかどうか
function selectContinue()
{
    echo "「1:続ける 2:終了 半角で番号を入力してください」"; //文字の1にすると終了になる
    $select = trim(fgets(STDIN)); //入力後文字列を返す
    if (mb_convert_kana($select, "n") == SELECT) { //全角を半角に戻し判定。半角の1を入力すればtrue
        return true;
    } else {
        echo "終了しました";
    }
}
