<!-- Left Main Content Column: Writer Canvas -->
                    <div class="col-lg-8">
                        <div class="card editor-card p-4 p-md-5 border-0 shadow-sm h-100 rounded-4">
                            <!-- Large Stylized Post Title Input -->
                            <div class="mb-1">
                                <label for="title" class="visually-hidden">Story Title</label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       class="form-control title-input border-0 bg-transparent px-0 @error('title') is-invalid @enderror" 
                                       placeholder="Title of your story..." 
                                       value="{{ old('title') }}" 
                                       required 
                                       autocomplete="off">
                                @error('title')
                                    <div class="invalid-feedback ps-1 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr class="editor-divider my-3">
                            <!-- Minimalist Writing Text Area -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <button type="button" class="btn btn-sm text-info p-0"
                                            onclick="improveGrammar()">Improve Writing with Tots Bot
                                    </button>
                                    <label for="content" class="visually-hidden">Write your thoughts...</label>
                                </div>
                                <textarea name="content" 
                                          id="content" 
                                          class="form-control content-input border-0 bg-transparent px-0 @error('content') is-invalid @enderror" 
                                          rows="12" 
                                          placeholder="Tell your story. Tap into your imagination, research notes, and insights..." 
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback ps-1 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Right Sidebar Column: Publishing Control Panel -->
                    <div class="col-lg-4">
                        <!-- Publishing Options Card -->
                        <div class="card sidebar-card p-4 pb-2 border-0 shadow-sm rounded-4 h-100 mb-4">
                            <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                                <i class="bi bi-sliders text-brand"></i> Publish Controls
                            </h5>
                            <!-- Cover/Featured Image Upload Zone -->
                            <div class="mb-3">
                                <label class="form-label text-uppercase tracking-wide small fw-bold text-muted">Cover Image</label>
                                <div class="upload-zone position-relative text-center p-4 rounded-4" id="upload-zone">
                                    <input type="file" 
                                           name="featured_image" 
                                           id="featured_image" 
                                           class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" 
                                           accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <!-- Upload Placeholder State -->
                                    <div id="upload-placeholder">
                                        <div class="upload-icon-wrapper mx-auto mb-2">
                                            <i class="bi bi-image text-brand fs-4"></i>
                                        </div>
                                        <span class="d-block small fw-bold text-dark mb-1">Upload banner photo</span>
                                        <span class="d-block text-muted" style="font-size: 0.75rem;">JPEG, PNG, WEBP (Max 2MB)</span>
                                    </div>
                                    <!-- Upload Active Preview State -->
                                    <div id="upload-preview-container" class="d-none">
                                        <img id="image-preview" src="#" alt="Cover Preview" class="img-fluid rounded-3 mb-2 shadow-sm">
                                        <div class="d-flex justify-content-center align-items-center gap-1 text-brand small fw-semibold">
                                            <i class="bi bi-arrow-repeat"></i> Change Image
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Post Visibility Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label text-uppercase tracking-wide small fw-bold text-muted">Visibility Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Save as Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Immediately</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Custom Story Excerpt (Optional Summary) -->
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="excerpt" class="form-label text-uppercase tracking-wide small fw-bold text-muted mb-0">Story Excerpt</label>
                                    <span class="text-muted" style="font-size: 0.75rem;">Optional</span>
                                </div>
                                <textarea name="excerpt" 
                                          id="excerpt" 
                                          class="form-control excerpt-textarea @error('excerpt') is-invalid @enderror" 
                                          rows="3" 
                                          maxlength="500" 
                                          placeholder="A short, catchy summary for preview cards...">{{ old('excerpt') }}</textarea>
                                <div class="form-text text-primary small" style="font-size: .75rem";>
                                    If left empty, we will auto-generate one from your main text.
                                </div>
                                @error('excerpt')
                                    <div class="invalid-feedback mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- NEW: Tags Input Field Section -->
                            <div class="mb-4">
                                <label for="tags" class="form-label text-uppercase tracking-wide small fw-bold text-muted">
                                    Story Tags (Keywords)
                                </label>
                                <input type="text" name="tags" id="tags" class="form-control rounded-3 @error('tags') is-invalid @enderror" value="{{ old('tags') }}" placeholder="e.g., Technology, Life, Productivity, Coding">
                                <div class="form-text text-muted fs-11 mt-1.5">
                                    <span class="text-primary" style="font-size: 0.75rem;">Separate individual tags with commas. These drive the trending topics algorithms.</span>
                                </div>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Submit and Save Action Buttons -->
                            <button type="submit" id="submit-btn" class="btn btn-brand w-100 py-2.5 rounded-pill fw-bold mb-2">
                                <span id="submit-text">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Save and Publish
                                </span>
                                <span id="submit-loading" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Publishing...
                                </span>
                            </button>
                            <a href="{{ route('pages.index') }}" class="btn btn-outline-custom btn-sm text-center rounded-pill px-3 py-2">
                                Cancel
                            </a>
                        </div>
                    </div>