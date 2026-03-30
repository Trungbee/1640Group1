@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-pencil-square"></i> Edit Ideal</h3>
        <a href="{{ route('staff.mySubmissions') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-md-9 mx-auto">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5">

                    <form action="{{ route('staff.updateIdea', $idea->ideaId) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold">Idea Title</label>
                            <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $idea->title) }}" placeholder="Nhập tiêu đề ngắn gọn" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="10" placeholder="Giải thích chi tiết về ý tưởng của bạn..." required>{{ old('description', $idea->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Select Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->categoryId }}" {{ old('category_id', $idea->categoryId) == $category->categoryId ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold">Change File</label>

                            <div class="bg-light p-3 rounded mb-2 d-flex align-items-center justify-content-between border">
                                <div class="small">
                                    <i class="bi bi-file-earmark-check-fill text-primary me-2"></i> Current File:
                                    <strong class="text-dark">{{ basename($idea->filePath) }}</strong>
                                </div>
                                <a href="{{ route('staff.downloadIdea', $idea->ideaId) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-download"></i> Download old files
                                </a>
                            </div>

                            <input type="file" name="document" class="form-control @error('document') is-invalid @enderror" accept=".pdf,.doc,.docx">
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Leave blank if you do not want to modify the file. Allowed formats: Word, PDF. Maximum size: 10MB.</small>
                            @error('document') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg px-5 w-100 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-check2-circle me-1"></i> Save Changes
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
