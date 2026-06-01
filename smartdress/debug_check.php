<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Vetement;

// Delete the orphan test vetement (photo file doesn't exist)
$v = Vetement::find(16);
if ($v) {
    $v->photos()->delete();
    $v->delete();
    echo "Deleted orphan vetement id=16\n";
} else {
    echo "Vetement 16 not found (already deleted)\n";
}

// Verify
echo "\nRemaining vetements: " . Vetement::count() . "\n";

// Verify storage link is working
$storageLinkPath = public_path('storage');
echo "Storage link exists: " . (file_exists($storageLinkPath) ? 'YES' : 'NO') . "\n";
echo "Storage link is symlink: " . (is_link($storageLinkPath) ? 'YES' : 'NO') . "\n";
echo "Photos dir exists: " . (is_dir(storage_path('app/public/photos')) ? 'YES' : 'NO') . "\n";
