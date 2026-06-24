

<?php $__env->startSection('title', 'Edit Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-off-white py-4 sm:py-6">
    <div class="container mx-auto px-3 sm:px-4 max-w-4xl">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                <div class="w-full">
                    <h1 class="text-2xl sm:text-3xl font-bold text-navy-blue mb-1">Edit Dokumen</h1>
                    <p class="text-sm sm:text-base text-steel-blue/80 font-medium">Perbarui informasi metadata atau ganti file dokumen jika diperlukan.</p>
                </div>
                
                <a href="<?php echo e(route('dokumen.show', $dokumen->id)); ?>" 
                   class="w-full md:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-white text-navy-blue font-semibold rounded-xl shadow-lg border border-soft-gray hover:bg-off-white hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-navy-blue/50">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="text-sm sm:text-base">Kembali</span>
                </a>
            </div>
        </div>

        <!-- Error Alert -->
        <?php if($errors->any()): ?>
        <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm" role="alert">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-red-700 mb-1">Terdapat kesalahan dalam pengisian form</p>
                    <ul class="text-sm text-red-600 list-disc pl-5 space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
            <!-- Form Header -->
            <div class="px-4 sm:px-6 py-4 sm:py-5 bg-gradient-to-r from-navy-blue to-steel-blue">
                <div class="flex items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-white/10 flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-white">Form Edit Dokumen</h3>
                </div>
            </div>

            <!-- Form Content -->
            <form action="<?php echo e(route('dokumen.update', $dokumen->id)); ?>" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <!-- Grid Form Fields -->
                <div class="space-y-5 sm:space-y-6">
                    <!-- Judul Dokumen -->
                    <div>
                        <label class="block text-sm font-semibold text-navy-blue mb-2">
                            Judul Dokumen <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="judul_dokumen" 
                               value="<?php echo e(old('judul_dokumen', $dokumen->judul_dokumen)); ?>" 
                               class="w-full px-4 py-3 text-sm sm:text-base bg-off-white border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-blue/20 focus:border-navy-blue transition-all duration-200" 
                               placeholder="Masukkan judul dokumen" 
                               required>
                    </div>

                    <!-- Nomor & Tahun Dokumen Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                        <!-- Nomor Dokumen -->
                        <div>
                            <label class="block text-sm font-semibold text-navy-blue mb-2">
                                Nomor Dokumen <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nomor_dokumen" 
                                   value="<?php echo e(old('nomor_dokumen', $dokumen->nomor_dokumen)); ?>" 
                                   class="w-full px-4 py-3 text-sm sm:text-base bg-off-white border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-blue/20 focus:border-navy-blue transition-all duration-200" 
                                   placeholder="Contoh: 001/DPRD/2024" 
                                   required>
                        </div>

                        <!-- Tahun Dokumen -->
                        <div>
                            <label class="block text-sm font-semibold text-navy-blue mb-2">
                                Tahun Dokumen <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="tahun_dokumen" 
                                   value="<?php echo e(old('tahun_dokumen', $dokumen->tahun_dokumen)); ?>" 
                                   class="w-full px-4 py-3 text-sm sm:text-base bg-off-white border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-blue/20 focus:border-navy-blue transition-all duration-200" 
                                   placeholder="2024" 
                                   min="1900" 
                                   max="2100" 
                                   required>
                        </div>
                    </div>

                    <!-- Kategori & Unit Kerja Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-semibold text-navy-blue mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="id_kategori" 
                                    class="w-full px-4 py-3 text-sm sm:text-base bg-off-white border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-blue/20 focus:border-navy-blue transition-all duration-200" 
                                    required>
                                <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($k->id); ?>" <?php echo e(old('id_kategori', $dokumen->id_kategori) == $k->id ? 'selected' : ''); ?>>
                                        <?php echo e($k->nama_kategori); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Unit Kerja (Admin only) -->
                        <?php if(Auth::user()->role->nama_peran === 'Admin'): ?>
                        <div>
                            <label class="block text-sm font-semibold text-navy-blue mb-2">
                                Unit Kerja Pemilik
                            </label>
                            <select name="id_unit_kerja" 
                                    class="w-full px-4 py-3 text-sm sm:text-base bg-off-white border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-blue/20 focus:border-navy-blue transition-all duration-200">
                                <option value="">-- Pilih Unit Kerja --</option>
                                <?php $__currentLoopData = $unitKerja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($u->id); ?>" <?php echo e(old('id_unit_kerja', $dokumen->id_unit_kerja) == $u->id ? 'selected' : ''); ?>>
                                        <?php echo e($u->nama_unit); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- File Upload Section -->
                    <div class="border-t border-soft-gray pt-5 sm:pt-6">
                        <label class="block text-sm font-semibold text-navy-blue mb-3">
                            Ganti File Dokumen
                            <span class="text-xs font-normal text-steel-blue/60">(Opsional)</span>
                        </label>
                        
                        <!-- Current File Info -->
                        <div class="bg-gradient-to-r from-navy-blue/5 to-steel-blue/5 border border-soft-gray rounded-lg sm:rounded-xl p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-navy-blue/10 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-navy-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-blue mb-0.5">File saat ini</p>
                                        <a href="<?php echo e(route('dokumen.download', $dokumen->id)); ?>" 
                                           target="_blank" 
                                           class="text-sm text-steel-blue hover:text-navy-blue hover:underline transition-colors inline-flex items-center">
                                            <?php echo e($dokumen->judul_dokumen); ?>.<?php echo e($dokumen->tipe_file); ?>

                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-steel-blue/10 text-steel-blue">
                                    <?php echo e(strtoupper($dokumen->tipe_file)); ?>

                                </span>
                            </div>
                        </div>

                        <!-- File Upload Input -->
                        <div class="relative">
                            <input type="file" 
                                   name="file_dokumen" 
                                   id="file-upload"
                                   class="hidden">
                            <label for="file-upload" 
                                   class="cursor-pointer flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-soft-gray rounded-lg sm:rounded-xl hover:border-navy-blue/40 hover:bg-off-white transition-all duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-charcoal/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                    </svg>
                                    <p class="text-sm text-charcoal/60 mb-1">
                                        <span class="font-semibold text-navy-blue">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-charcoal/40">PDF, DOC, DOCX, XLS, XLSX (Max: 10MB)</p>
                                </div>
                            </label>
                        </div>
                        <p class="text-xs text-steel-blue/60 mt-2">Biarkan kosong jika tidak ingin mengganti file.</p>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-semibold text-navy-blue mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" 
                                  rows="4" 
                                  class="w-full px-4 py-3 text-sm sm:text-base bg-off-white border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-navy-blue/20 focus:border-navy-blue transition-all duration-200 resize-none"
                                  placeholder="Tambahkan deskripsi atau keterangan mengenai dokumen ini..."><?php echo e(old('deskripsi', $dokumen->deskripsi)); ?></textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 sm:pt-8 mt-6 sm:mt-8 border-t border-soft-gray">
                    <div class="w-full sm:w-auto">
                        <a href="<?php echo e(route('dokumen.show', $dokumen->id)); ?>" 
                           class="w-full inline-flex items-center justify-center px-6 py-3 text-sm sm:text-base font-semibold text-charcoal/70 hover:text-charcoal transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                    <div class="w-full sm:w-auto">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-navy-blue text-white font-semibold rounded-xl shadow-lg hover:bg-steel-blue hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-navy-blue/50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Perbarui Dokumen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Colors - Same as reference */
    :root {
        --navy-blue: #0A2540;
        --steel-blue: #334E68;
        --off-white: #F8F9FB;
        --white: #FFFFFF;
        --charcoal: #111827;
        --soft-gray: #E5E7EB;
    }

    .bg-navy-blue { background-color: var(--navy-blue); }
    .text-navy-blue { color: var(--navy-blue); }
    .bg-steel-blue { background-color: var(--steel-blue); }
    .text-steel-blue { color: var(--steel-blue); }
    .bg-off-white { background-color: var(--off-white); }
    .text-charcoal { color: var(--charcoal); }
    .border-soft-gray { border-color: var(--soft-gray); }
    
    /* Focus ring */
    .focus\:ring-navy-blue\/20:focus {
        --tw-ring-color: rgba(10, 37, 64, 0.2) !important;
    }
    
    .focus\:ring-navy-blue\/50:focus {
        --tw-ring-color: rgba(10, 37, 64, 0.5) !important;
    }
    
    /* Gradient */
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }
</style>

<script>
    // File upload preview enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-upload');
        const dropArea = fileInput.parentElement.querySelector('label[for="file-upload"]');
        
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            dropArea.classList.add('border-navy-blue', 'bg-navy-blue/5');
        }
        
        function unhighlight(e) {
            dropArea.classList.remove('border-navy-blue', 'bg-navy-blue/5');
        }
        
        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Show file name
            if (files.length > 0) {
                const fileName = files[0].name;
                const fileSize = (files[0].size / (1024*1024)).toFixed(2);
                dropArea.innerHTML = `
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 mb-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-navy-blue mb-1">File siap diupload</p>
                        <p class="text-xs text-charcoal/60">${fileName}</p>
                        <p class="text-xs text-charcoal/40 mt-1">${fileSize} MB</p>
                    </div>
                `;
            }
        }
        
        // Handle click file selection
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                const fileSize = (this.files[0].size / (1024*1024)).toFixed(2);
                dropArea.innerHTML = `
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 mb-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-navy-blue mb-1">File siap diupload</p>
                        <p class="text-xs text-charcoal/60">${fileName}</p>
                        <p class="text-xs text-charcoal/40 mt-1">${fileSize} MB</p>
                    </div>
                `;
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\arsip desa v2\desav2\resources\views/dokumen/edit.blade.php ENDPATH**/ ?>