<?php

namespace Korona\Generators;

use Codedge\Fpdf\Fpdf\Fpdf;

class LabelPdf extends Fpdf
{
    const UNIT = 'mm';
    const MARGIN_TOP = 8;
    const COLUMNS = 3;
    const ROWS = 8;
    const HEIGHT = 35;
    const WIDTH = 70;
    const YOFF0 = 0;
    const YOFF1 = 1;
    const YOFF2 = 4;
    const YOFF3 = 6;
    const YOFF4 = 8;
    const YOFF5 = 9;
    const YOFF6 = 11;
    const YOFF7 = 12;
    const YOFFDEF = 2;
    const FSIZE_SENDER = 7;
    const FSIZE = 10;
    const FSIZEALT = 9;
    const LABELMARGIN = 6;
    const LNNORMAL = 4;
    const LNNORMALALT = 3;
    const LNSMALL = 3;
    const LNSMALLALT = 2;
    const LNLARGE = 10;
    const FONT = 'Arial';
    const PAGEFORMAT = 'A4';
    const ORIENTATION = 'P';
    protected $receivers = null;

    public function __construct($sender, $receivers)
    {
        parent::__construct();
        $this->sender = $sender;
        $this->receivers = $receivers;
    }

    public function labels()
    {
        $this->SetMargins(1, 1, 1);
        $this->SetAutoPageBreak(false);
        $column = 0;
        $row = 0;
        $this->AddPage();
        foreach ($this->receivers as $receiver) {
            if ($receiver->address !== null) {
                $this->label($receiver, $column, $row);
                $column++;
                if ($column > (self::COLUMNS - 1)) {
                    $row++;
                    $column = 0;
                }
                if ($row > (self::ROWS - 1)) {
                    $column = 0;
                    $row = 0;
                    $this->AddPage();
                }
            }
        }
        $this->Output('labels.pdf', 'D');
        exit;
    }

    public function label($receiver, $column, $row)
    {
        // Absender
        $this->SetFont(self::FONT, 'U', self::FSIZE_SENDER);
        switch ($row) {
            case 0:
                $yoffset = self::YOFF0;
                break;
            case 1:
                $yoffset = self::YOFF1;
                break;
            case 2:
                $yoffset = self::YOFF2;
                break;
            case 3:
                $yoffset = self::YOFF3;
                break;
            case 4:
                $yoffset = self::YOFF4;
                break;
            case 5:
                $yoffset = self::YOFF5;
                break;
            case 6:
                $yoffset = self::YOFF6;
                break;
            case 7:
                $yoffset = self::YOFF7;
                break;
            default:
                $yoffset = self::YOFFDEF;
                break;
        }
        $this->SetY(($row * self::HEIGHT) + self::MARGIN_TOP + $yoffset);
        $this->SetX(($column * self::WIDTH) + self::LABELMARGIN);
        $this->Cell(self::WIDTH - self::LABELMARGIN, 3, utf8_decode($this->sender()), 0, 2);
        $this->Ln(self::LNSMALL);
        $this->SetFont(self::FONT,'', self::FSIZE);
        $this->SetX(($column * self::WIDTH) + self::LABELMARGIN);
        $this->Cell(self::WIDTH - self::LABELMARGIN, 0, utf8_decode($receiver->getCivilName(true)), 0, 2);
        $this->Ln(self::LNSMALL);
        $this->SetX(($column * self::WIDTH) + self::LABELMARGIN);
        $address = explode("\n", $receiver->address->getFormatted());
        foreach ($address as $line) {
            $this->Cell(self::WIDTH - self::LABELMARGIN, 0, utf8_decode($line), 0, 2);
            $this->Ln(self::LNSMALL);
            $this->SetX(($column * self::WIDTH) + self::LABELMARGIN);
        }
    }

    public function sender()
    {
        return $this->sender;
    }
}
