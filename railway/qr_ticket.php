<?php
// Include phpqrcode library
require_once __DIR__ . '/phpqrcode/qrlib.php';

function build_ticket_payload(array $ticket): string
{
    // Convert the ticket array into a compact JSON string for encoding in QR
    return json_encode($ticket, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function generate_qr_img_tag(string $payload, int $size = 300, array $attrs = []): string
{
    // Encode payload for use inside the QR URL
    $chl = rawurlencode($payload);
    $chs = intval($size) . 'x' . intval($size);

    // Google Chart API QR endpoint
    $src = "https://chart.googleapis.com/chart?cht=qr&chs={$chs}&chl={$chl}&chld=L|1";

    // Build attributes string
    $attrs_str = '';
    foreach ($attrs as $k => $v) {
        $k = htmlspecialchars($k, ENT_QUOTES);
        $v = htmlspecialchars((string)$v, ENT_QUOTES);
        $attrs_str .= " {$k}=\"{$v}\"";
    }

    return "<img src=\"{$src}\" width=\"{$size}\" height=\"{$size}\" alt=\"QR Ticket\"{$attrs_str} />";
}

function generate_qr_data_uri(string $payload, int $size = 300): ?string
{
    // Try to use local QR generation via qr_generate_png()
    $png_data = qr_generate_png($payload, intval($size));
    if ($png_data === null) {
        return null;
    }
    $b64 = base64_encode($png_data);
    return "data:image/png;base64,{$b64}";
}

// QR code generation using phpqrcode library with fallback
function qr_generate_png(string $payload, int $size = 300): ?string
{
    try {
        // Check if GD extension is loaded
        if (!extension_loaded('gd')) {
            return null; // GD not available, fallback to API
        }
        
        // Create temporary file for QR code
        $temp_file = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
        
        // Generate QR code using phpqrcode
        // Parameters: data, file, error correction level, pixel size
        $pixel_size = max(1, intval($size / 200));
        QRcode::png($payload, $temp_file, 'L', $pixel_size, 2);
        
        // Read the generated PNG file
        $png_data = file_get_contents($temp_file);
        
        // Clean up temporary file
        if (file_exists($temp_file)) {
            unlink($temp_file);
        }
        
        return $png_data !== false ? $png_data : null;
    } catch (Exception $e) {
        return null;
    }
}

?>