<div id="about" data-aos="zoom-out" data-aos-delay="600">
    <div class="container">
        <div class="row">
            <!-- Kiri -->
            <div class="col-sm-12 mt-3">
                <h4 class="text-center"><?php echo $title; ?></h4>
                <hr>
                <form method="post" action="<?php echo site_url('welcome/submit'); ?>">
                    <input type="hidden" name="survey_id" value="<?php echo $survey->id; ?>">
                    <input type="hidden" name="survey_slug" value="<?php echo $survey->slug; ?>">

                    <?php foreach ($questions as $i => $q): ?>
                    <?php
                        $meta = json_decode($q->meta, true);
                        $req = isset($meta['required']) && $meta['required'] ? 'required' : '';
                        ?>
                    <div class="form-group">
                        <label><b><?php echo ($i + 1) . ". " . $q->label; ?>
                                <?php if (isset($meta['required']) && $meta['required']): ?><span
                                    style="color: red;">*</span><?php endif; ?></b></label>

                        <?php if ($q->type == 'text'): ?>
                        <input type="text" class="form-control" name="q_<?php echo $q->id; ?>" <?php echo $req; ?>>

                        <?php elseif ($q->type == 'textarea'): ?>
                        <textarea class="form-control" name="q_<?php echo $q->id; ?>" rows="3"
                            <?php echo $req; ?>></textarea>

                        <?php elseif (in_array($q->type, ['radio', 'checkbox', 'select'])): ?>
                        <?php $options = isset($meta['options']) ? $meta['options'] : []; ?>

                        <?php if ($q->type == 'radio'): ?>
                        <?php foreach ($options as $opt): ?>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="q_<?php echo $q->id; ?>"
                                value="<?php echo $opt; ?>">
                            <label class="form-check-label"><?php echo $opt; ?></label>
                        </div>
                        <?php endforeach; ?>

                        <?php elseif ($q->type == 'checkbox'): ?>
                        <?php foreach ($options as $opt): ?>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="q_<?php echo $q->id; ?>[]"
                                value="<?php echo $opt; ?>">
                            <label class="form-check-label"><?php echo $opt; ?></label>
                        </div>
                        <?php endforeach; ?>

                        <?php elseif ($q->type == 'select'): ?>
                        <select class="form-control" name="q_<?php echo $q->id; ?>">
                            <?php foreach ($options as $opt): ?>
                            <option value="<?php echo $opt; ?>"><?php echo $opt; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-primary my-3">Kirim Survei</button>
                </form>
            </div>
        </div>
    </div>
</div>